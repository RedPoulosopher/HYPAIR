<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

use \App\Services\AutorisationGestion;

class ProtectionAutorisation
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $autorisation_necessaire)
    {
        $role = AutorisationGestion::recuperer_role($autorisation_necessaire);
        if($role == "non authentifié") abort(403);
        else if($role == "non membre") abort(403);
        else if( $role[$autorisation_necessaire] != 1) abort(403);

        return $next($request);
    }
}
