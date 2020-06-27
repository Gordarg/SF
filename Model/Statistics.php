<?php
/**
 * 
 * A core model for statistics and analysis
 * which is called from core/controller
 * 
 */

class Statistics extends Model {

    function InsertVisit($Values) {
        $Query = 'INSERT INTO `visits`
        (`CONTEXT_DOCUMENT_ROOT`, `CONTEXT_PREFIX`, `DOCUMENT_ROOT`, `GATEWAY_INTERFACE`, `HTTP_ACCEPT`, `HTTP_ACCEPT_ENCODING`, `HTTP_ACCEPT_LANGUAGE`, `HTTP_CACHE_CONTROL`, `HTTP_CONNECTION`, `HTTP_COOKIE`, `HTTP_HOST`, `HTTP_REFERER`, `HTTP_SEC_FETCH_DEST`, `HTTP_SEC_FETCH_MODE`, `HTTP_SEC_FETCH_SITE`, `HTTP_SEC_FETCH_Person`, `HTTP_UPGRADE_INSECURE_REQUESTS`, `HTTP_Person_AGENT`, `PATH`, `PATH_INFO`, `PATH_TRANSLATED`, `PHP_SELF`, `QUERY_STRING`, `REDIRECT_STATUS`, `REDIRECT_URL`, `REMOTE_ADDR`, `REMOTE_PORT`, `REQUEST_METHOD`, `REQUEST_SCHEME`, `REQUEST_TIME`, `REQUEST_TIME_FLOAT`, `REQUEST_URI`, `SCRIPT_FILENAME`, `SCRIPT_NAME`, `SERVER_ADDR`, `SERVER_ADMIN`, `SERVER_NAME`, `SERVER_PORT`, `SERVER_PROTOCOL`, `SERVER_SIGNATURE`, `SERVER_SOFTWARE`)
        VALUES
        (:CONTEXT_DOCUMENT_ROOT, :CONTEXT_PREFIX, :DOCUMENT_ROOT, :GATEWAY_INTERFACE, :HTTP_ACCEPT, :HTTP_ACCEPT_ENCODING, :HTTP_ACCEPT_LANGUAGE, :HTTP_CACHE_CONTROL, :HTTP_CONNECTION, :HTTP_COOKIE, :HTTP_HOST, :HTTP_REFERER, :HTTP_SEC_FETCH_DEST, :HTTP_SEC_FETCH_MODE, :HTTP_SEC_FETCH_SITE, :HTTP_SEC_FETCH_Person, :HTTP_UPGRADE_INSECURE_REQUESTS, :HTTP_Person_AGENT, :PATH, :PATH_INFO, :PATH_TRANSLATED, :PHP_SELF, :QUERY_STRING, :REDIRECT_STATUS, :REDIRECT_URL, :REMOTE_ADDR, :REMOTE_PORT, :REQUEST_METHOD, :REQUEST_SCHEME, :REQUEST_TIME, :REQUEST_TIME_FLOAT, :REQUEST_URI, :SCRIPT_FILENAME, :SCRIPT_NAME, :SERVER_ADDR, :SERVER_ADMIN, :SERVER_NAME, :SERVER_PORT, :SERVER_PROTOCOL, :SERVER_SIGNATURE, :SERVER_SOFTWARE)';
        $Result = $this->DoQuery($Query, $Values);
        return $Result;
    }

}