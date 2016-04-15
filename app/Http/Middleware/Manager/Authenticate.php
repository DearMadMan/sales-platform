<?php
    namespace App\Http\Middleware\Manager;

    use Closure;
    use Auth;

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
            Auth::logout();
            return redirect ('manager/login');
        }

    }
