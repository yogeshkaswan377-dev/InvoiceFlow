import './bootstrap';
import Alpine from 'alpinejs';

import gstinManager from './components/gstin-manager';
import stateSearch from './components/state-search';
import gstRatesManager from './components/gst-rates-manager';
import bankDetails from './components/bank-details';
import fileUpload from './components/file-upload';
import clientSearch from './components/client-search';

window.Alpine = Alpine;

Alpine.data('gstinManager', gstinManager);
Alpine.data('stateSearch', stateSearch);
Alpine.data('gstRatesManager', gstRatesManager);
Alpine.data('bankDetails', bankDetails);
Alpine.data('fileUpload', fileUpload);
Alpine.data('clientSearch', clientSearch);

Alpine.start();