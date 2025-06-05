import Axios from 'axios';

/*
INTERCEPTORS
URL INFO: https://axios-http.com/docs/interceptors
 */

// Add a response interceptor
Axios.interceptors.response.use(function (response) {
    // Do something with response data
    return response;
}, function (error) {
    //Si da error con el mensaje de perdida de session, volver al login Si se cambia editar en SapRequestHelper de Shared

    if (error.response.data.message === 'SAP Session expired') {
        location.href  = "/login"
    }

    throw error;

});