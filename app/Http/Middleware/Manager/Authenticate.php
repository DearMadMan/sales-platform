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

            if ( ! $request->user () || ! $request->user ()->user_type_id > 2) {

                return redirect ('manager/login');
            }

            return $next($request);
        }

    }
