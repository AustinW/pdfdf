<?php

namespace Austinw\Pdfdf;

use Wesnick\FdfUtility\PdfForm;
use Shuble\Slurpy\Factory as PDFTKFactory;
use Wesnick\FdfUtility\Parser\PdftkDumpParser;
use Wesnick\FdfUtility\FdfWriter;

use PdfdfFileNotFoundException;

class Pdfdf
{
	protected $fdfUtility;

	protected $fdfFactory;

	protected $tmpStorageLocation;

	protected $pdfStorageLocation;

	protected $pdftkDumpParser;

	protected $fdfWriter;

	protected $fileName;

	protected $_eraseTempFDF;

	public function __construct(PdfForm $fdfUtility, PdftkDumpParser $pdftkDumpParser, FdfWriter $fdfWriter)
	{
		$this->fdfUtility = $fdfUtility;

		$this->pdftkDumpParser = $pdftkDumpParser;

		$this->fdfWriter = $fdfWriter;
	}

	public function getUtility()
	{
		return $this->fdfUtility;
	}

	public function registerFactory(PDFTKFactory $factory)
	{
		$this->fdfFactory = $factory;
	}

	public function registerFieldHandler(PdfFieldHandlerInterface $fieldHanlder)
	{
		$this->fieldHandler = $fieldHandler;
	}

	public function setConfiguration(array $config)
	{
		$this->tmpStorageLocation = $config['tmp'];

		$this->pdfStorageLocation = $config['pdf'];

		$this->_eraseTempFDF = $config['erase_temp_fdf'];
	}

	public function extractFields($inputPdf)
	{
		$tempStorageLocation = $this->tmpStorageLocation ?: sys_get_temp_dir();

		$fieldsDump = tempnam($tempStorageLocation, 'fdf_dump');

		$dataDumper = $this->fdfFactory->dumpDataFields($inputPdf, $fieldsDump);

		$dataDumper->generate(array(), true);

		$this->pdftkDumpParser->setCurrentContents($fieldsDump);

		$fields = $this->pdftkDumpParser->parse();

		if ($this->_eraseTempFDF) {
			unlink($fieldsDump);
		}

		return $fields;
	}

	public function generate($inputPdf, $outputPdf, $fields)
	{
		foreach ($fields as $field) $this->fdfWriter->addField($field);

		$tempStorageLocation = $this->tmpStorageLocation ?: sys_get_temp_dir();
		
		$fdfFile = tempnam($tempStorageLocation, 'fdf');

		$this->fdfWriter->generate();
		$this->fdfWriter->save($fdfFile);

		$this->setFileName($outputPdf);

		$formFiller = $this->fdfFactory->fillForm($inputPdf, $fdfFile, $this->getFileName());
		$formFiller->generate();

		if ($this->_eraseTempFDF) {
			unlink($fdfFile);
		}
	}

	public function setFileName($outputPdf)
	{
		$this->fileName = $this->pdfStorageLocation . DIRECTORY_SEPARATOR . $outputPdf . '_' . self::str_random(5) . '.pdf';
	}

	public function getFileName()
	{
		return $this->fileName;
	}

	public function fill($inputPdf, $outputPdf)
	{
		if ( ! file_exists($inputPdf))
			throw new PdfdfFileNotFoundException('Input pdf file could not be located');

		$fields = $this->fdfUtility->extractFields($this->fdfFactory, $inputPdf, $outputPdf, $this->tmpStorageLocation);
	}

	private static function str_random($length = 10)
	{
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, strlen($characters) - 1)];
		}
		return $randomString;
	}
}