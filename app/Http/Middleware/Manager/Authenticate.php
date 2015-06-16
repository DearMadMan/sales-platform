<?php
    namespace App\Http\Middleware\Manager;

    use Closure;

    class Authenticate
    {

        /**
         * Handle an incoming request.
         *
         * @param  \Illuminate\Http\Request $request
         * @param  \Closure $next
         * @return mixed
         */
        public function handle ($request , Closure $next)
        {

            $user = $request->user ();
            if ($user && $user->isManager () || $request->is ('manager/login')) {
                return $next($request);
            }

            return redirect ('manager/login');
        }

    }
