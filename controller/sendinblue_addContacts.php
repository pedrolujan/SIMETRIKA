<?php

// PHP SDK: https://github.com/sendinblue/APIv3-php-library
// $res=agergarContactos("javierlujan1203@gmail.com","cantuta","miriam","miriam cantyta","949382653","",98);

// $estado=ActualizarAtributosContacto("Herhuay Chocce", "Ma", "Marco Antonio", "+51940171100", "milinkkk", "maherhuay@gmail.com");
// if($estado==true){
// echo "Todo OK";
// }else{

//     echo "errort";
// }

function agergarContactos($email, $apellidos, $primerNombre, $nombres, $telefono,$LinkCertificado, $idLista)
{
    require_once('../vendor/autoload.php');

    // Configure API key authorization: api-key
    $config = SendinBlue\Client\Configuration::getDefaultConfiguration()->setApiKey('api-key', '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');

    $apiInstance = new SendinBlue\Client\Api\ContactsApi(
        new GuzzleHttp\Client(),
        $config
    );

    // $res=agergarContactos("oogkgka@gmail.com","cantuta","miriam","miriam cantyta","+51949382655",$idLista);

    $createContact = new \SendinBlue\Client\Model\CreateContact(); // Values to create a contact
    $createContact['email'] = $email;
    $createContact['attributes'] = array('APELLIDOS' => $apellidos, 'PRIMER_NOMBRE' => $primerNombre, 'NOMBRE' => $nombres, 'TELEFONO' => $telefono,'LINK_CERTIFICADO'=>$LinkCertificado );
    $createContact['listIds'] = [$idLista];

    try {
        $result = $apiInstance->createContact($createContact);
        if($result==true){
            return true;
        }else{
            return false;
        }
        // return ($result);
    } catch (Exception $e) {
        return ($e->getMessage());
        // echo 'Exception when calling ContactsApi->createContact: ', $e->getMessage(), PHP_EOL;
    }
}

function agergarContactosSinTelefono($email, $apellidos, $primerNombre, $nombres,$LinkCertificado, $idLista)
{
    require_once('../vendor/autoload.php');
    $config = SendinBlue\Client\Configuration::getDefaultConfiguration()->setApiKey('api-key', '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');

    $apiInstance = new SendinBlue\Client\Api\ContactsApi(
        new GuzzleHttp\Client(),
        $config
    );
    $createContact = new \SendinBlue\Client\Model\CreateContact(); // Values to create a contact
    $createContact['email'] = $email;
    $createContact['attributes'] = array('APELLIDOS' => $apellidos, 'PRIMER_NOMBRE' => $primerNombre, 'NOMBRE' => $nombres,'LINK_CERTIFICADO'=>$LinkCertificado);
    $createContact['listIds'] = [$idLista];

    try {
        $result = $apiInstance->createContact($createContact);
        if ($result) {
            return true;
        } else {
            return false;
        }
    } catch (Exception $e) {
        return false;
        // return $e->getCode();
        print_r($e);
        echo 'Exception when calling ContactsApi->createContact: ', $e->getMessage(), PHP_EOL;
    }
}

// actualizo los atributos del contacto que ya esta reguistrado
function ActualizarAtributosContacto($apellidos, $primerNombre, $nombres, $telefono,$LinkCertificado, $identificador)
{
    require_once('../vendor/autoload.php');

    $config = SendinBlue\Client\Configuration::getDefaultConfiguration()->setApiKey('api-key', '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');

    $apiInstance = new SendinBlue\Client\Api\ContactsApi(
        new GuzzleHttp\Client(),
        $config
    );

    $identifier = $identificador;
    $updateContact = new \SendinBlue\Client\Model\UpdateContact();
    // $updateContact['email'] = $email;
    $updateContact['attributes'] = array('APELLIDOS' => $apellidos, 'PRIMER_NOMBRE' => $primerNombre, 'NOMBRE' => $nombres, 'TELEFONO' => $telefono,'LINK_CERTIFICADO'=>$LinkCertificado );

    try {
        $apiInstance->updateContact($identifier, $updateContact);
        if ($apiInstance) {
            return true;
        } else {
            return false;
        }
    } catch (Exception $e) {
        return $e->getCode();
        // echo 'Exception when calling ContactsApi->updateContact: ', $e->getMessage(), PHP_EOL;
    }
}

function borrarContacto($email)
{
    require_once('../vendor/autoload.php');

    $config = SendinBlue\Client\Configuration::getDefaultConfiguration()->setApiKey('api-key', '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');

    $apiInstance = new SendinBlue\Client\Api\ContactsApi(
        new GuzzleHttp\Client(),
        $config
    );

    $identifier = $email;

    try {
        $apiInstance->deleteContact($identifier);

        if ($apiInstance) {
            return true;
        } else {
            return false;
        }
    } catch (Exception $e) {
        return false;
        echo 'Exception when calling ContactsApi->deleteContact: ', $e->getMessage(), PHP_EOL;
    }
}


function buscarContacto($email)
{
    require_once('../vendor/autoload.php');

    $config = SendinBlue\Client\Configuration::getDefaultConfiguration()->setApiKey('api-key', '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');

    $apiInstance = new SendinBlue\Client\Api\ContactsApi(
        new GuzzleHttp\Client(),
        $config
    );


    $identifier = $email;

    try {
        $result = $apiInstance->getContactInfo($identifier);
        // if ($result) {

        return $result["email"];
        // } else {
        //     echo "no se encontro";
        // }
    } catch (Exception $e) {
        return $e->getCode();
        // echo 'Exception when calling ContactsApi->getContactInfo: ', $e->getMessage(), PHP_EOL;
    }
}


function fnAgregarContactoAotraLista($idLista, $email)
{
    require_once('../vendor/autoload.php');

    $config = SendinBlue\Client\Configuration::getDefaultConfiguration()->setApiKey('api-key', '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');

    $apiInstance = new SendinBlue\Client\Api\ContactsApi(
        new GuzzleHttp\Client(),
        $config
    );

    $listId = $idLista;
    $contactIdentifiers = new \SendinBlue\Client\Model\AddContactToList();
    $contactIdentifiers['emails'] = array($email);

    try {
        $result = $apiInstance->addContactToList($listId, $contactIdentifiers);
        if ($result) {
            return true;
        } else {
            return false;
        }
    } catch (Exception $e) {
        return $e->getCode();
        //echo 'Exception when calling ContactsApi->addContactToList: ', $e->getMessage(), PHP_EOL;
    }
}

/* 
fnEnviarCorreo();
function fnEnviarCorreo(){
    
    require_once('../vendor/autoload.php');

    $config = SendinBlue\Client\Configuration::getDefaultConfiguration()->setApiKey('api-key', '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');

    $apiInstance = new SendinBlue\Client\Api\EmailCampaignsApi(
        new GuzzleHttp\Client(),
        $config
    );
    $campaignId = 164;
    $emailTo = new \SendinBlue\Client\Model\SendTestEmail();
    $emailTo['emailTo'] = array('lujanmarcelo1203@gmail.com');
    
    try {
        $apiInstance->SendTestEmail($campaignId, $emailTo);
    } catch (Exception $e) {
        echo 'Exception when calling EmailCampaignsApi->sendTestEmail: ', $e->getMessage(), PHP_EOL;
    }
} */
