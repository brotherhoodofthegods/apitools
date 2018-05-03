<?php
namespace BrotherhoodOfTheGods\ApiToolsBundle\Http;

use FOS\RestBundle\Context\Context;
use FOS\RestBundle\View\View;
use FOS\RestBundle\View\ViewHandler;

/**
 * Description of ApiResponse
 */
class ApiResponse
{
    const SUCCESS = 'OK';
    const ERROR = 'Error';

    /** @var ViewHandler $viewHandler */
    private $viewHandler;

    public function __construct(ViewHandler $viewHandler)
    {
        $this->viewHandler = $viewHandler;
    }

    /**
     * @param $status
     * @param mixed $data Error data
     * @param array $groups
     * @param string $format
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function render($status, $data = null, $groups = [], $format = 'json')
    {
        if($data instanceof \Exception)
            $responseData = array('Message' => $data->getMessage());

        else if(is_array($data) || is_object($data))
            $responseData = $data;

        else if(empty($data) && $status == self::SUCCESS)
            $responseData = null;

        else if(is_string($data))
            $responseData = array('Message' => $data);

        else
            $responseData = array(
                'Error data' => $data,
                'Message' => 'Unknown error'
            );

        $view = View::create()
                    ->setStatusCode($status == self::SUCCESS ? 200 : 400)
                    ->setFormat($format)
                    ->setData(array(
                        'status' => $status,
                        'data' => $responseData
                    ));

        if(!empty($groups)) {
            $context = new Context();
            $context->setGroups($groups);
            $view->setContext($context);
        }

        return $this->viewHandler->handle($view);
    }

    /**
     * @static
     * @param bool $value
     * @return string
     */
    public static function getStatusFromBoolean($value)
    {
        if($value)
            return self::SUCCESS;

        return self::ERROR;
    }
}
