require('../css/admin.scss');
require('@fortawesome/fontawesome-free/js/all.js');

require('startbootstrap-sb-admin/js/sb-admin.min.js');
require('startbootstrap-sb-admin/css/sb-admin.min.css');
require('startbootstrap-sb-admin/vendor/bootstrap/js/bootstrap.bundle.min.js');

import 'trix/dist/trix.css';
import 'trix/dist/trix.js';

const $ = require('jquery');

require('bootstrap');

const Swal = require('sweetalert2');

(function(globalFlashMessages) {
    globalFlashMessages.forEach(function(messageData) {
        Swal.fire({
            'type': messageData.type,
            'title': messageData.text,
            confirmButtonText: 'Ok',
        })
    });
})(globalFlashMessages);
