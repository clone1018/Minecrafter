<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Geo Location Plugin
 *
 * @package        CodeIgniter
 * @subpackage        System
 * @category        Plugin
 */

// ------------------------------------------------------------------------

/*    
Instructions:

Load the plugin using:

     $this->load->plugin('geo_location');

Once loaded you can get user's geo location details by IP address
    
    $ip = $this->input->ip_address();
    $geo_data = geolocation_by_ip($ip);
    
    echo "Country code : ".$geo_data['country_name']."\n";
    echo "Country name : ".$geo_data['city']."\n";
    ...
    

NOTES:
    
    The get_geolocation function will use current IP address, if IP param is not given.

RETURNED DATA

The get_geolocation() function returns an associative array with this data:

  [array]
  (
    'ip'=>$ip, 
    'country_code'=>$result->CountryCode, 
    'country_name'=>$result->CountryName, 
    'region_name'=>$result->RegionName, 
    'city'=>$result->City, 
    'zip_postal_code'=>$result->ZipPostalCode, 
    'latitude'=>$result->Latitude, 
    'longitude'=>$result->Longitude, 
    'timezone'=>$result->Timezone, 
    'gmtoffset'=>$result->Gmtoffset, 
    'dstoffset'=>$result->Dstoffset
  )
*/


/**
 * Get Geo Location by Given/Current IP address
 *
 * @access    public
 * @param    string
 * @return    array
 */
if (!function_exists('get_geolocation')) {
    
    function get_geolocation($ip) {

        $apikey = '1db40484cd3ae4f3f851e6a2fc060489a770d1c201d840801f298ffc0c8e871b';

        $location = json_decode(file_get_contents("http://api.ipinfodb.com/v3/ip-city/?key=$apikey&ip=$ip&format=json"), true);

        return $location;
    }
}
/* End of file geo_location_pi.php */
/* Location: ./system/plugins/geo_location_pi.php */ 