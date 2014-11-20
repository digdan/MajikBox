<?php
	class Majik_autocolor extends MajikEffect {
		function process(Imagick $target) {

			$clipLow = 0.1;
			$clipHigh = 0.9;
			$mag = 1;

			$area = $target->getImageWidth() * $target->getImageHeight();
			$target->setImageColorspace( imagick::COLORSPACE_RGB );
		
			//Build RGB means and ratios
			$redMean = $target->getImageChannelMean( imagick::CHANNEL_RED );
			$blueMean = $target->getImageChannelMean( imagick::CHANNEL_BLUE );
			$greenMean = $target->getImageChannelMean( imagick::CHANNEL_GREEN );
			$lumMean = $target->getImageChannelMean( imagick::CHANNEL_GRAY );

			$redRatio = ($lumMean['mean'] / $redMean['mean']) * $mag;
			$blueRatio = ($lumMean['mean'] / $blueMean['mean']) * $mag;
			$greenRatio = ($lumMean['mean'] / $greenMean['mean']) * $mag;
		
			//echo "R: {$redRatio} B: {$blueRatio} G: {$greenRatio}\n";

			$out = clone $target;
			
			$red = clone $target;
			$red->setImageColorspace( imagick::COLORSPACE_RGB );
			$red->separateImageChannel( imagick::CHANNEL_RED );
			$red->recolorImage( array(
				$redRatio,0,0,
				0,0,0,
				0,0,0
			));

			$blue = clone $target;
			$blue->setImageColorspace( imagick::COLORSPACE_RGB );
			$blue->separateImageChannel( imagick::CHANNEL_BLUE );
			$blue->recolorImage( array(
				0,0,0,
				0,0,0,
				$blueRatio,0,0
			));

			$green = clone $target;
			$green->setImageColorspace( imagick::COLORSPACE_RGB );
			$green->separateImageChannel( imagick::CHANNEL_GREEN );
			$green->recolorImage( array(
				0,0,0,
				$greenRatio,0,0,
				0,0,0
			));

			$red->contrastStretchImage( $clipLow * $area, $clipHigh * $area, imagick::CHANNEL_RED );
			$blue->contrastStretchImage( $clipLow * $area, $clipHigh * $area, imagick::CHANNEL_BLUE );
			$green->contrastStretchImage( $clipLow * $area, $clipHigh * $area, imagick::CHANNEL_GREEN );

			$rgb = new Imagick();
			$rgb->newImage($target->getImageWidth(),$target->getImageHeight(), 'rgba(0,0,0,0)');
			$rgb->compositeImage($red, imagick::COMPOSITE_COPYRED, 0, 0, imagick::CHANNEL_RED);
			$rgb->compositeImage($green, imagick::COMPOSITE_COPYGREEN, 0, 0, imagick::CHANNEL_GREEN);
			$rgb->compositeImage($blue, imagick::COMPOSITE_COPYBLUE, 0, 0, imagick::CHANNEL_BLUE);

			$rgb->setImageFormat( $target->getImageFormat() );

			return $rgb;

		}
	}

	MajikBox::add( 'autocolor', new Majik_autocolor() );
?>
