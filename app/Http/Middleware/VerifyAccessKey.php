<?php

namespace apirest\Http\Middleware;

use Closure;

class VerifyAccessKey
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        //obtenemos el api-key que el usuario envia

        // si coincide con el valor almacenado en la aplicacion
        // la aplicacion se sigue ejecutando

        $key = $request->headers->get('app_key');
        if(isset($key) == env('APP_KEY')){
            return $next($request);

        }else{

            // si falla devolcemos el mensaje de error
            return response()->json(['errors'=>'unauthorized'],401);
        }

        return $next($request);
    }
}
