import './styles/app.css';
import "admin-lte/dist/js/adminlte";
import "./bootstrap";
// assets/app.js

import EpisodeController from './controllers/episode_controller';

const application = Application.start();
application.register('episode', EpisodeController);