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

        $asso = Association::where('uid', $request->route('slug_asso'));
        if($asso->exists()){
            $asso_id = $asso->get('id')->first()["id"];
            $input["association_id"] = $asso_id;
            $input["association_slug"] = $request->route('slug_asso');
			$request->replace($input);
		}else{
			return abort(405);
		}

        return $next($request);
    }
}
