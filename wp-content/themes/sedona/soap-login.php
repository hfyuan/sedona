<?php

  $objSoapClient = new SoapClient(
    'http://residentsync.propertysolutions.com/?service_type=properties',
    array ( "encoding"=>"ISO-8859-1",
      "trace"=>1,
      "exceptions"=>0,
      "connection_timeout"=>1000 ));
  $authInfo = new stdClass();
  $authInfo->managementCompanyId = 1593;
  $authInfo->companySubDomain = 'jbg';
  $authInfo->username = 'REAmits@jbg';
  $authInfo->password = 'reamits22';
  $propertyId = '53369';
    $params = new stdClass();
  $params->authInfo = $authInfo;
  $params->propertyId = $propertyId;
  $response = $objSoapClient->getMitsFormattedProperties($params);
  // resulting in
  header ("content-type: text/xml");
  echo $response->mitsXml;


?>
