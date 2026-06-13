import { startStimulusApp } from '@symfony/stimulus-bridge';

// The regex /\.(j|t)sx?$/ matches .js, .ts, .jsx, and .tsx files
const app = startStimulusApp(require.context('./controllers', true, /\.(j|t)sx?$/));
// register any custom, 3rd party controllers here
// app.register('some_controller_name', SomeImportedController);
