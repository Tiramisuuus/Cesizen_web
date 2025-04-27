// assets/bootstrap.js
import './styles/app.css';
import 'bootstrap/dist/js/bootstrap.bundle';
import 'bootstrap/dist/css/bootstrap.min.css';

import { startStimulusApp } from '@symfony/stimulus-bridge';

const application = startStimulusApp(require.context(
    // votre dossier de controllers (relatif à assets/)
    './controllers',
    true,
    /\.[jt]sx?$/
));

// Si vous voulez ajouter Bootstrap 5 par exemple :
import * as bootstrap from 'bootstrap';
window.bootstrap = bootstrap;
