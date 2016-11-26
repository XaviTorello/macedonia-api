<?php
use App\Lib\Auth,
    App\Lib\Response,
    App\Lib\GeneralFunction,
    App\Validation\PermisionValidation,
    App\Middleware\AuthMiddleware,
    App\Middleware\PermisionMiddleware;


$app->group('/admin/permision/', function () {
    /**
     * @api {post} /user/register 
     * @apiGroup user
     * @apiName Register
     * @apiDescription Route to create new user in the platform
     * @apiVersion 0.0.1
     * 
     * @apiParam {string} name name to register.
     * @apiParam {string} email email to register.
     * @apiParam {string} password password to register.
     * @apiParam {string} repassword repassword to register.
     *
     *
     * @apiSuccessExample {json} Success-Response
     *     HTTP/1.1 200 OK
     *     {
     *       {
     *           "result": ""
     *           "response": true
     *           "message": ""
     *           "errors": [0]
     *           }
     *     }
     * @apiSuccessExample {json} Unprocessable Entity
     *     HTTP/1.1 422 Unprocessable Entity
     *     {
     *       {
     *
     *        - "name": [1]
     *          0:  "Este campo es obligatorio"
     *        - "email": [1]
     *          0:  "Este campo es obligatorio"
     *        - "password": [1]
     *          0:  "Este campo es obligatorio"
     *        - "repassword": [1]
     *          0:  "Este campo es obligatorio"
     *       }
     *     }
     *
     * 
     */
    $this->post('new', function ($req, $res, $args) {
        $expected_fields = array('url','group_user');

        $data = GeneralFunction::createNullData($req->getParsedBody(),$expected_fields);

        $r = userValidation::Validate($data);

         if(!$r->response){
            return $res->withHeader('Content-type', 'application/json')
                       ->withStatus(422)
                       ->write(json_encode($r->errors));
        }

       return $res->withHeader('Content-type', 'application/json')
                   ->write(
                     json_encode($this->controller->user->register($data))
        ); 

    });

   /**
     * @api {put} /user/update
     * @apiGroup user
     * @apiName Update
     * @apiDescription Route to update name or password
     * @apiVersion 0.0.1
     * @apiHeader {String} access-key Users unique access-key.
     *
     * 
     * @apiParam {string} name name to register.
     * @apiParam {string} password password to register.
     * @apiParam {string} repassword repassword to register.
     *
     *
     * @apiSuccessExample {json} Success-Response
     *     HTTP/1.1 200 OK
     *     {
     *       {
     *           "result": ""
     *           "response": true
     *           "message": ""
     *           "errors": [0]
     *        }
     *     }
     * @apiSuccessExample {json} Unprocessable Entity
     *     HTTP/1.1 422 Unprocessable Entity
     *     {
     *       {
     *
     *        - "name": [1]
     *          0:  "Este campo es obligatorio"
     *        - "password": [1]
     *          0:  "Este campo es obligatorio"
     *        - "repassword": [1]
     *          0:  "Este campo es obligatorio"
     *       }
     *     }
     *     
     * @apiSuccessExample {json} Unauthorized
     *     HTTP/1.1 401 Unauthorized
     *     {
     *        {
     *         "result": null
     *         "response": false
     *         "message": "Unauthorized token not valid"
     *         "errors": [0]
     *         }
     *     }
     *
     *
     * 
     */
   $this->put('update', function ($req, $res, $args) {
        $expected_fields = array('name','password','repassword');

        $data = GeneralFunction::createNullData($req->getParsedBody(),$expected_fields);
        
        $r = userValidation::Validate($data,true);
        
        
        if(!$r->response){
            return $res->withHeader('Content-type', 'application/json')
                       ->withStatus(422)
                       ->write(json_encode($r->errors));
        }

        return $res->withHeader('Content-type', 'application/json')
                   ->write(
                     json_encode($this->controller->user->update($data,$token = $req->getHeader($this->settings['app_token_name'])[0]))
                   ); 
    })->add(new AuthMiddleware($this));


   $this->get('url/{number}', function ($req, $res, $args) {
        echo "dentro";

       /* $expected_fields = array('name','password','repassword');

        $data = GeneralFunction::createNullData($req->getParsedBody(),$expected_fields);
        
        $r = userValidation::Validate($data,true);
        
        
        if(!$r->response){
            return $res->withHeader('Content-type', 'application/json')
                       ->withStatus(422)
                       ->write(json_encode($r->errors));
        }

        return $res->withHeader('Content-type', 'application/json')
                   ->write(
                     json_encode($this->controller->user->update($data,$token = $req->getHeader($this->settings['app_token_name'])[0]))
                   ); */
    })->add(new AuthMiddleware($this))->add(new PermisionMiddleware($this));


 
 
}); 