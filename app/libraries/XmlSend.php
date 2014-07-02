<?php
class XmlSend  {
    const HTTP_SUCCESS = 200;
    const HTTP_SUCCESS_CREATED = 201;
    const HTTP_FAIL_VALIDATION = 400;
    const HTTP_FAIL_AUTH = 401;
    const HTTP_FAIL_ACL = 403;
    const HTTP_ERROR_NOT_FOUND = 404;
    const HTTP_ERROR_OTHER = 500;

    /**
     * Retourne une réponse JSEND de succès avec le code de status HTTP.
     * Si le code du status n'est pas fournit, il vaut par défaut 200.
     *
     * @param mixed $data
     * @param int $status
     * @return \Illuminate\Http\JsonResponse
     */
    public static function success($data = null, $status = null)
    {
        // Choisit un code de status HTTP par défaut si non spécifié
        if (!isset($status)) {
            $status = self::HTTP_SUCCESS;
        }
        $rep = array();
        $rep['status'] = 'success';
        $rep['data'] = $data;
        return ArrayToXml::buildXMLData($rep);
        
    }

    /**
     * Retourne une réponse JSEND d'échec avec le code de status HTTP.
     * Si le code du status n'est pas fournit, il vaut par défaut 400.
     *
     * @param mixed $data
     * @param int $status
     * @return \Illuminate\Http\JsonResponse
     */
    public static function fail($data, $status = null)
    {
        // Choisit un code de status HTTP par défaut si non spécifié
        if (!isset($status)) {
            $status = self::HTTP_FAIL_VALIDATION;
        }
        $rep = new stdClass();
        $rep->status = 'fail';
        $rep->data = $data;
        return Response::json($rep, $status);
    }

    /**
     * Retourne une réponse JSEND d'erreur avec le code de status HTTP.
     * Si le code du status n'est pas fournit, il vaut par défaut 404.
     *
     * @param string $message
     * @param int $status
     * @return \Illuminate\Http\JsonResponse
     */
    public static function error($message, $status = null)
    {
        // Choisit un code de status HTTP par défaut si non spécifié
        if (!isset($status)) {
            $status = self::HTTP_ERROR_NOT_FOUND;
        }
        $rep = new stdClass();
        $rep->status = 'error';
        $rep->message = $message;
        return Response::json($rep, $status);
    }

}