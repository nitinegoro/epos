<?php
if (!defined('BASEPATH')) exit('No direct script access permitted.');
/**
 * Class Untuk memotong gambar
 *
 * @see http://arif.suparlan.com/2009/09/11/resize-crop-gambar-proporsional-di-codeigniter
 **/
class Cropping
{
    protected $CI;
  
    public function resize_crop($config, $resize_width=200, $resize_height=200) {
        if ($config) {
            $this->CI =& get_instance();
            $this->CI->load->library('image_lib');
              
            $img_size = getimagesize($config['source_image']);
              
            $t_ratio = $resize_width / $resize_height;
            $o_width = $img_size[0];
            $o_height = $img_size[1];

            if ($t_ratio > $o_width/$o_height) {
                $config['width'] = $resize_width;
                $config['height'] = round( $resize_width * ($o_height / $o_width));
                $y_axis = round(($config['height']/2) - ($resize_height/2));
                $x_axis = 0;
            } else {
                $config['width'] = round( $resize_height * ($o_width / $o_height));
                $config['height'] = $resize_height;
                $y_axis = 0;
                $x_axis = round(($config['width']/2) - ($resize_width/2));
            }
          
            $source_img01 = $config['new_image'];
          
            $this->CI->image_lib->clear();
            $this->CI->image_lib->initialize($config);
            $this->CI->image_lib->resize();
          
            $config['image_library'] = 'gd2';
            $config['source_image'] = $source_img01;
            $config['create_thumb'] = false;
            $config['maintain_ratio'] = false;
            $config['width'] = $resize_width;
            $config['height'] = $resize_height;
            $config['y_axis'] = $y_axis ;
            $config['x_axis'] = $x_axis ;
          
            $this->CI->image_lib->clear();
            $this->CI->image_lib->initialize($config);
            $this->CI->image_lib->crop();
          
            return $config['new_image'];
        }
        return FALSE;
    }
}