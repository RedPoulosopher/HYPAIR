<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use \App\Models\Association;

class ExistenceAsso
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $input =$request->all();

        $asso = Association::where('slug', $request->route('slug_asso'));
        if($asso->exists()){
            $input["association_model"] = $asso;
            $asso_id = $asso->get('id')->first()["id"];
            $input["association_id"] = $asso_id;
			$request->replace($input);
		}else{
			return abort(405);
		}

        return $next($request);
    }
}
