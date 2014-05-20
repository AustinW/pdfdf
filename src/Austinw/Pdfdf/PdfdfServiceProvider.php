<?php namespace Austinw\Pdfdf;

use Illuminate\Support\ServiceProvider;
use Wesnick\FdfUtility\PdfForm;
use Wesnick\FdfUtility\Parser\PdftkDumpParser;
use Wesnick\FdfUtility\FdfWriter;
use Shuble\Slurpy\Factory as PDFTKFactory;

class PdfdfServiceProvider extends ServiceProvider {

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->package('austinw/pdfdf');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('pdfdf.factory', function($app) {
            $factoryPath = $app['config']->get('pdfdf::pdftk');

            return new PDFTKFactory($factoryPath);
        });

        $this->app['pdfdf'] = $this->app->share(function($app) {
            $pdfdf = new Pdfdf(new PdfForm, new PdftkDumpParser, new FdfWriter);
            $pdfdf->registerFactory($app['pdfdf.factory']);

            $pdfdf->setConfiguration(array(
                'tmp'            => $app['config']->get('pdfdf::storage.tmp'),
                'pdf'            => $app['config']->get('pdfdf::storage.pdf'),
                'erase_temp_fdf' => $app['config']->get('pdfdf::erase_temp_fdf'),
            ));

            return $pdfdf;
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array('pdfdf');
    }

}