<?php
/**
 * ezcGraphBackgroundTest 
 * 
 * @package Graph
 * @version //autogen//
 * @subpackage Tests
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

require_once dirname( __FILE__ ) . '/test_case.php';

/**
 * Tests for ezcGraph class.
 * 
 * @package ImageAnalysis
 * @subpackage Tests
 */
class ezcGraphBackgroundTest extends ezcGraphTestCase
{
    protected $testFiles = array(
        'jpeg'          => 'jpeg.jpg',
        'nonexistant'   => 'nonexisting.jpg',
        'invalid'       => 'text.txt',
    );

	public static function suite()
	{
		return new PHPUnit_Framework_TestSuite( "ezcGraphBackgroundTest" );
	}

    protected function setUp()
    {
        static $i = 0;

        $this->tempDir = $this->createTempDir( __CLASS__ . sprintf( '_%03d_', ++$i ) ) . '/';
        $this->basePath = dirname( __FILE__ ) . '/data/';
    }

    protected function tearDown()
    {
        if ( !$this->hasFailed() )
        {
            $this->removeTempDir();
        }
    }

    public function testSetOptionsInvalidBackgroundImage()
    {
        try 
        {
            $pieChart = new ezcGraphPieChart();
            $pieChart->background->image = $this->basePath . $this->testFiles['invalid'];
        } 
        catch ( ezcGraphInvalidImageFileException $e ) 
        {
            return true;
        } 

        $this->fail( 'Expected ezcGraphInvalidImageFileException' );
    }

    public function testSetOptionsNonexistantBackgroundImage()
    {
        try 
        {
            $pieChart = new ezcGraphPieChart();
            $pieChart->background->image = $this->basePath . $this->testFiles['nonexistant'];
        } 
        catch ( ezcBaseFileNotFoundException $e ) 
        {
            return true;
        } 

        $this->fail( 'Expected ezcBaseFileNotFoundException' );
    }

    public function testSetOptionsBackground()
    {
        $pieChart = new ezcGraphPieChart();
        $pieChart->background->color = '#FF0000';

        $this->assertEquals( 
            ezcGraphColor::fromHex( 'FF0000' ),
            $pieChart->background->color
        );
    }

    public function testSetOptionsBorder()
    {
        $pieChart = new ezcGraphPieChart();
        $pieChart->background->border = '#FF0000';

        $this->assertEquals( 
            ezcGraphColor::fromHex( 'FF0000' ),
            $pieChart->background->border
        );
    }

    public function testSetOptionsBorderWidth()
    {
        $pieChart = new ezcGraphPieChart();
        $pieChart->background->borderWidth = 3;

        $this->assertSame( 3, $pieChart->background->borderWidth );
    }

    public function testRenderPieChartWithBackgroundBottomRight()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';

        $chart = new ezcGraphPieChart();
        $chart->data['sample'] = new ezcGraphArrayDataSet( array(
            'Mozilla' => 4375,
            'IE' => 345,
            'Opera' => 1204,
            'wget' => 231,
            'Safari' => 987,
        ) );

        $chart->background->color = '#FFFFFFDD';
        $chart->background->image = dirname( __FILE__ ) . '/data/ez.png';
        $chart->background->position = ezcGraph::BOTTOM | ezcGraph::RIGHT;

        $chart->driver = new ezcGraphSvgDriver();
        $chart->render( 500, 200, $filename );

        $this->compare(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.svg'
        );
    }

    public function testRenderPieChartWithTextureBackground()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';

        $chart = new ezcGraphPieChart();
        $chart->data['sample'] = new ezcGraphArrayDataSet( array(
            'Mozilla' => 4375,
            'IE' => 345,
            'Opera' => 1204,
            'wget' => 231,
            'Safari' => 987,
        ) );

        $chart->background->color = '#FFFFFFDD';
        $chart->background->image = dirname( __FILE__ ) . '/data/texture.png';
        $chart->background->repeat = ezcGraph::HORIZONTAL | ezcGraph::VERTICAL;

        $chart->driver = new ezcGraphSvgDriver();
        $chart->render( 500, 200, $filename );

        $this->compare(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.svg'
        );
    }

    public function testRenderPieChartWithBackgroundBottomCenter()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';

        $chart = new ezcGraphPieChart();
        $chart->data['sample'] = new ezcGraphArrayDataSet( array(
            'Mozilla' => 4375,
            'IE' => 345,
            'Opera' => 1204,
            'wget' => 231,
            'Safari' => 987,
        ) );

        $chart->background->color = '#FFFFFFDD';
        $chart->background->image = dirname( __FILE__ ) . '/data/ez.png';
        $chart->background->position = ezcGraph::BOTTOM | ezcGraph::CENTER;

        $chart->driver = new ezcGraphSvgDriver();
        $chart->renderer = new ezcGraphRenderer3d();
        $chart->render( 500, 200, $filename );

        $this->compare(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.svg'
        );
    }

    public function testRenderPieChartWithHorizontalTextureBackground()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';

        $chart = new ezcGraphPieChart();
        $chart->data['sample'] = new ezcGraphArrayDataSet( array(
            'Mozilla' => 4375,
            'IE' => 345,
            'Opera' => 1204,
            'wget' => 231,
            'Safari' => 987,
        ) );

        $chart->background->color = '#FFFFFFDD';
        $chart->background->image = dirname( __FILE__ ) . '/data/texture.png';
        $chart->background->repeat = ezcGraph::HORIZONTAL;
        $chart->background->position = ezcGraph::BOTTOM;

        $chart->driver = new ezcGraphSvgDriver();
        $chart->renderer = new ezcGraphRenderer3d();
        $chart->render( 500, 200, $filename );

        $this->compare(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.svg'
        );
    }

}
?>
