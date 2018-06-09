<?php

namespace src\Security;



class AccessDeniedHandler implements AccessDeniedHandlerInterface {

    public function handle(Request $request, AccessDeniedException $accessDeniedException) {
        return new Response('Acceso denegado, 403');
    }

}
