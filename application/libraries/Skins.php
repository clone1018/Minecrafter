<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Skins { 

	public function __construct() {
		$this->CI = get_instance();
	}

	public function minecraft_skin_3d_part($id, $original, $user, $xpos, $ypos, $width, $height, $texturesize, $name, $flipx, $flipy) {
		$temp = imagecreatetruecolor($texturesize,$texturesize);
		$trans = imagecolorallocatealpha($temp,255,255,255,127);
		$x = $xpos;
		$y = $ypos;
		$w = $width;
		$h = $height;
		imagealphablending($temp, false);
		imagesavealpha($temp, true);
		if($flipx == TRUE && $flipy == TRUE) {
			$xpos = $xpos + $width -1;
			$width = 0 - $width;
			$ypos = $ypos + $height -1;
			$height = 0 - $height;
		} elseif($flipx == TRUE) {
			$xpos = $xpos + $width-1;
			$width = 0 - $width;
		} elseif($flipy == TRUE) {
			$ypos = $ypos + $height-1;
			$height = 0 - $height;
		}
		//Copy Part To New 'Canvas'
		imagecopyresampled($temp, $original, 0, 0, $xpos, $ypos, $texturesize, $texturesize, $width, $height);
		//Make One-Color Hats Transparent
		$match = imagecolorat($original,$x,$y);
		$transparent = true;
		if(substr($name,0,3) == "hat") {
			for ($x2=$x;$x2<($x+$w);$x2++) {
				for ($y2=$y;$y2<($y+$h);$y2++) {
					if(imagecolorat($original,$x2,$y2) != $match) {
						$transparent = false;
						break 2;
					}
				}
			}
		}
		if ($transparent == true && substr($name,0,3) == "hat") {
			imagefilledrectangle($temp,0,0,$texturesize,$texturesize,$trans);
		}
		//Save Image
		imagepng($temp, "uploads/skins/".$id."/".$name.".png");
		imagedestroy($temp); 
	}

	public function minecraft_skin_download($id, $user) {
		if(!file_exists('uploads/skins/'.$id.'/base.png')) {
			if(@getimagesize('https://minecrafter.com/uploads/skins/'.$user.'.png')) {
				if(!is_dir('uploads/skins/'.$id)) {
					mkdir('uploads/skins/'.$id, 0777);
				}

				//Download the skin from Minecraft.net and put it in /images/skins/
				$url = 'https://minecrafter.com/uploads/skins/'.$user.'.png';
				$img = 'uploads/skins/'.$id.'/base.png';
				file_put_contents($img, file_get_contents($url));

				//Create another image twice the size
				$original = imagecreatefrompng('uploads/skins/'.$id.'/base.png');

				/////////////////////////
				// Body Parts (for 3D) //
				/////////////////////////

				$this->minecraft_skin_3d_part($id,$original,$user,40,0,8,8,256,"hat_top", TRUE, TRUE);
				$this->minecraft_skin_3d_part($id,$original,$user,48,0,8,8,256,"hat_bottom", TRUE, TRUE);
				$this->minecraft_skin_3d_part($id,$original,$user,32,8,8,8,256,"hat_left", FALSE, FALSE);
				$this->minecraft_skin_3d_part($id,$original,$user,40,8,8,8,256,"hat_front", FALSE, FALSE);
				$this->minecraft_skin_3d_part($id,$original,$user,48,8,8,8,256,"hat_right", FALSE, FALSE);
				$this->minecraft_skin_3d_part($id,$original,$user,56,8,8,8,256,"hat_back", FALSE, FALSE);

				$this->minecraft_skin_3d_part($id,$original,$user,8,0,8,8,256,"head_top", TRUE, TRUE);
				$this->minecraft_skin_3d_part($id,$original,$user,16,0,8,8,256,"head_bottom", TRUE, TRUE);
				$this->minecraft_skin_3d_part($id,$original,$user,0,8,8,8,256,"head_left", FALSE, FALSE);
				$this->minecraft_skin_3d_part($id,$original,$user,8,8,8,8,256,"head_front", FALSE, FALSE);
				$this->minecraft_skin_3d_part($id,$original,$user,16,8,8,8,256,"head_right", FALSE, FALSE);
				$this->minecraft_skin_3d_part($id,$original,$user,24,8,8,8,256,"head_back", FALSE, FALSE);

				$this->minecraft_skin_3d_part($id,$original,$user,20,16,8,4,256,"body_top", FALSE, TRUE);
				$this->minecraft_skin_3d_part($id,$original,$user,28,16,8,4,256,"body_bottom", FALSE, TRUE);
				$this->minecraft_skin_3d_part($id,$original,$user,16,20,4,12,256,"body_right", TRUE, FALSE);
				$this->minecraft_skin_3d_part($id,$original,$user,20,20,8,12,256,"body_front", FALSE, FALSE);
				$this->minecraft_skin_3d_part($id,$original,$user,28,20,4,12,256,"body_left", TRUE, FALSE);
				$this->minecraft_skin_3d_part($id,$original,$user,32,20,8,12,256,"body_back", FALSE, FALSE);

				$this->minecraft_skin_3d_part($id,$original,$user,44,16,4,4,256,"arm_left_top", FALSE, TRUE);
				$this->minecraft_skin_3d_part($id,$original,$user,48,16,4,4,256,"arm_left_bottom", FALSE, TRUE);
				$this->minecraft_skin_3d_part($id,$original,$user,40,20,4,12,256,"arm_left_outer", FALSE, FALSE);
				$this->minecraft_skin_3d_part($id,$original,$user,44,20,4,12,256,"arm_left_front", FALSE, FALSE);
				$this->minecraft_skin_3d_part($id,$original,$user,48,20,4,12,256,"arm_left_inner", FALSE, FALSE);
				$this->minecraft_skin_3d_part($id,$original,$user,52,20,4,12,256,"arm_left_back", FALSE, FALSE);

				$this->minecraft_skin_3d_part($id,$original,$user,44,16,4,4,256,"arm_right_top", TRUE, TRUE);
				$this->minecraft_skin_3d_part($id,$original,$user,48,16,4,4,256,"arm_right_bottom", TRUE, TRUE);
				$this->minecraft_skin_3d_part($id,$original,$user,40,20,4,12,256,"arm_right_outer", TRUE, FALSE);
				$this->minecraft_skin_3d_part($id,$original,$user,44,20,4,12,256,"arm_right_front", TRUE, FALSE);
				$this->minecraft_skin_3d_part($id,$original,$user,48,20,4,12,256,"arm_right_inner", FALSE, FALSE);
				$this->minecraft_skin_3d_part($id,$original,$user,52,20,4,12,256,"arm_right_back", TRUE, FALSE);

				$this->minecraft_skin_3d_part($id,$original,$user,4,16,4,4,256,"leg_left_top", FALSE, TRUE);
				$this->minecraft_skin_3d_part($id,$original,$user,8,16,4,4,256,"leg_left_bottom", FALSE, TRUE);
				$this->minecraft_skin_3d_part($id,$original,$user,0,20,4,12,256,"leg_left_outer", FALSE, FALSE);
				$this->minecraft_skin_3d_part($id,$original,$user,4,20,4,12,256,"leg_left_front", FALSE, FALSE);
				$this->minecraft_skin_3d_part($id,$original,$user,8,20,4,12,256,"leg_left_inner", FALSE, FALSE);
				$this->minecraft_skin_3d_part($id,$original,$user,12,20,4,12,256,"leg_left_back", FALSE, FALSE);

				$this->minecraft_skin_3d_part($id,$original,$user,4,16,4,4,256,"leg_right_top", TRUE, TRUE);
				$this->minecraft_skin_3d_part($id,$original,$user,8,16,4,4,256,"leg_right_bottom", TRUE, TRUE);
				$this->minecraft_skin_3d_part($id,$original,$user,0,20,4,12,256,"leg_right_outer", TRUE, FALSE);
				$this->minecraft_skin_3d_part($id,$original,$user,4,20,4,12,256,"leg_right_front", TRUE, FALSE);
				$this->minecraft_skin_3d_part($id,$original,$user,8,20,4,12,256,"leg_right_inner", TRUE, FALSE);
				$this->minecraft_skin_3d_part($id,$original,$user,12,20,4,12,256,"leg_right_back", TRUE, FALSE);

				//Release original from memory (Skin from minecraft.net)
				imagedestroy($original);
			}
		}
	}

}