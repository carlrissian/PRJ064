const Axios = require('axios');
import Routing from '../../../vendor/friendsofsymfony/jsrouting-bundle/Resources/public/js/router.min.js';

/*
 LOGHELPER
 */
export function log(message, type = 'INFO', status = 200, method = 'GET')
{
    let logUrl = Routing.generate('log.push');

    let logMessage = {
        message: message,
        type: type,
        status: status,
        method: method,
    }

    Axios.post(logUrl, JSON.stringify(logMessage),
        {
            headers: {
                'Content-Type': 'application/form-data'
            }
        })

}