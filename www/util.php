<?php

function getRequestMethod(): string
{
    return strtoupper($_SERVER['REQUEST_METHOD']);
}

function getUris(): array
{
    $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    return explode('/', ltrim($uri, '/'));
}

function createUserFromRequest(): array
{
    return (array)json_decode(file_get_contents('php://input'), TRUE);
}

function getQueryStringParams(): array
{
    parse_str($_SERVER['QUERY_STRING'], $query);
    return $query;
}

function responseSuccess($responseData, $message = '')
{
    $data['status'] = true;
    $data['data'] = $responseData;
    $data['message'] = $message;

    sendOutput(json_encode($data),
        array('Content-Type: application/json', RESPONSE_HEADER_200)
    );
}

function responseError($strErrorDesc, $strErrorHeader)
{
    $data['status'] = false;
    $data['data'] = array();
    $data['message'] = $strErrorDesc;

    sendOutput(json_encode($data),
        array('Content-Type: application/json', $strErrorHeader)
    );
}

/**
 * Send API output.
 *
 * @param mixed $data
 * @param string $httpHeader
 */
function sendOutput($data, $httpHeaders = array())
{
    header_remove('Set-Cookie');

    if (is_array($httpHeaders) && count($httpHeaders)) {
        foreach ($httpHeaders as $httpHeader) {
            header($httpHeader);
        }
    }

    echo $data;
    exit;
}