<?php

<% namespaceInformations.forEach((namespaceInformation) => { %>
$GLOBALS['TYPO3_CONF_VARS']['SYS']['fluid']['namespaces']['<%= namespaceInformation.name %>'] = ['<%= extensionNamespace %>\ViewHelpers\<%= (namespaceInformation.path.join('\\')) %>'];
<% }); %>
