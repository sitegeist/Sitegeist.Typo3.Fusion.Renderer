'use strict';
const Generator = require('yeoman-generator');
const chalk = require('chalk');
const yosay = require('yosay');
const {$get} = require('plow-js');

module.exports = class extends Generator {

  constructor(args, opts) {
    super(args, opts);

    // This makes `appname` a required argument.
    this.option('name', {type: String, desc: 'The composer name of the package', required: true});
    this.option('ast', {type: String, desc: 'The path to the ast-file that will be imported', required: true});
    this.option('targetDirectory', {type: String, required: false} );
  }

  writing() {

    if (this.options.targetDirectory) {
      this.log(this.options.targetDirectory);
      this.destinationRoot(this.options.targetDirectory);
    }

    const name = this.options.name
    const extensionKey = name.split('/').pop().replace(/[\-]/gm,'_');
    const extensionNamespace = name.replace(/[\-\/]/gm, "\\");
    const astFile = 'Resources/Private/FusionAst.json';

    // read ast
    const ast = this.fs.readJSON(this.options.ast);

    // calculate viewHelperInformations
    const viewHelperInformations = this._extractViewHelperInformationsFromAst(ast);

    // extract the namespaces from the viewHelperInformations
    const namespaceInformations = this._extractNamespaceInformationsFromViewHelperInformations(viewHelperInformations);

    // create skeleton
    this.fs.copyTpl(
      this.templatePath('extension_skeleton/*'),
      this.destinationPath(),
      {
        name: name,
        extensionKey: extensionKey,
        extensionNamespace: extensionNamespace,
        astFile: astFile,
        viewHelperInformations: viewHelperInformations,
        namespaceInformations: namespaceInformations
      }
    );


    // store ast
    this.fs.writeJSON(astFile, ast);

    // create viewHelpers
    viewHelperInformations.forEach((viewHelperInformation) => {
      const templateVars = Object.assign(
        viewHelperInformation,
        {
          extensionKey: extensionKey,
          extensionNamespace: extensionNamespace,
          astFile: astFile
        }
      );

      this.fs.copyTpl(
        this.templatePath('extension_skeleton/Classes/ViewHelpers/ViewHelper.php'),
        this.destinationPath('Classes/ViewHelpers/' + viewHelperInformation['classPath'] + 'ViewHelper.php'),
        templateVars
      )
    });

    // delete viewHelpers folder
    // this.fs.delete(
    //   this.destinationPath('Classes/ViewHelpers')
    // )

  }

  _extractViewHelperInformationsFromAst(ast) {
    const astKeys = Object.keys(ast);
    const renderPathes = astKeys.filter((key) => key.match(/^render_.*/m));

    return renderPathes.map(
      (renderPath) => {

        const prototypeFullName = $get([renderPath ,'__objectType'], ast);
        const [prototypePackage, prototypeName] = prototypeFullName.split(':', 2);
        const propTypes = $get(['__prototypes', prototypeFullName, '__meta', 'propTypes'], ast) || {};
        const propTypeNames = Object.keys(propTypes);
        const path = prototypeFullName.replace(/[\.\:]/gm, "/");
        const pathSegments = path.split('/');
        const classPath = pathSegments.join('/');
        const viewHelperName = pathSegments.pop();
        const title = $get(['__prototypes', prototypeFullName, '__meta', 'styleguide', 'title'], ast) || '';
        const description = $get(['__prototypes', prototypeFullName, '__meta', 'styleguide', 'description'], ast) || '';

        const viewHelperPath = prototypeName.split('.');
        const viewHelperNamespace = pathSegments.join('\\');
        const viewHelperArguments = propTypeNames.map(
          (propTypeName) => {
            return this._extractArgumentInformationsFromProptype(propTypeName, $get([propTypeName ,'__eelExpression'], propTypes));
          }
        );

        const namespaceName = prototypePackage.replace(/[\.\:]/gm, '');
        const namespacePath = prototypePackage.split('.');

        return {
          title: title,
          description: description,
          renderPath: renderPath,
          propTypes: propTypes,

          classPath: classPath,

          prototypeFullName: prototypeFullName,
          prototypePackage: prototypePackage,
          prototypeName: prototypeName,

          viewHelperName: viewHelperName,
          viewHelperNamespace: viewHelperNamespace,
          viewHelperArguments: viewHelperArguments,
          viewHelperPath: viewHelperPath,

          namespaceName: namespaceName,
          namespacePath: namespacePath,
        }
      }
    );
  }

  _extractArgumentInformationsFromProptype(name, expression) {

    let type = 'mixed';
    if (expression.match(/^PropTypes\.boolean/)) {
      type = 'boolean';
    } else if (expression.match(/^PropTypes\.string/)) {
      type = 'string';
    } else if (expression.match(/^PropTypes\.float/)) {
      type = 'float';
    } else if (expression.match(/^PropTypes\.integer/)) {
      type = 'integer';
    }  else if (expression.match(/^PropTypes\.regex/)) {
      type = 'string';
    }  else if (expression.match(/^PropTypes\.arrayOf/)) {
      type = 'array';
    }  else if (expression.match(/^PropTypes\.shape/)) {
      type = 'array';
    }

    const required = expression.match(/isRequired$/);

    return {
      name: name,
      type: type,
      default: null,
      required: required,
      expression: expression,
    }
  }

  _extractNamespaceInformationsFromViewHelperInformations(viewHelperInformations) {

    return viewHelperInformations
      .map(
        (item) => ( {name: item.namespaceName, path: item.namespacePath} )
      ).filter(
        (item, index, self) => (
          self.findIndex(i => item.place === item.place && i.name === item.name) === index
        )
      );
  }

  install() {
  }
};
