<?php
// IPv4 Address Class
class CKORP_IPv4 {

  var $ip_address;
  var $binary_ip_address;
  var $subnet_mask;
  var $binary_subnet_mask;
  var $cidr;
  var $binary_cidr;
  var $total_hosts;
  var $network_address;
  var $broadcast_address;

  function get_address_info($address){
    $address_array = explode("/", $address);
    $this->ip_address = $address_array[0];
    $this->binary_ip_address = $this->Decimal_To_Binary($this->ip_address);
    if(strlen($address_array[1]) <= 2){
      // CIDR was passed
      $this->subnet_mask = $this->CIDR_To_SubnetMask($address_array[1]);
      $this->cidr = $address_array[1];
    }else{
      // Subnet Mask was passed
      $this->subnet_mask = $address_array[1];
      $this->cidr = $this->SubnetMask_To_CIDR($address_array[1]);
    }
    $this->binary_subnet_mask = $this->Decimal_To_Binary($this->subnet_mask);
    $this->network_address = $this->Get_Network_Address($this->ip_address, $this->subnet_mask);
    $this->total_hosts = $this->Get_Total_Hosts_From_CIDR($this->cidr);
    $this->broadcast_address = $this->Get_Broadcast_From_NetworkCIDR($this->network_address, $this->cidr);
  }


  function Binary_To_Decimal($address){
    $binary_array = explode(".", $address);
    return bindec($binary_array[0]).".".bindec($binary_array[1]).".".bindec($binary_array[2]).".".bindec($binary_array[3]);
  }

  function Decimal_To_Binary($address){
    $address_array = explode(".", $address);
    $octet[0] = str_pad(decbin($address_array[0]), 8, "0", STR_PAD_LEFT);
    $octet[1] = str_pad(decbin($address_array[1]), 8, "0", STR_PAD_LEFT);
    $octet[2] = str_pad(decbin($address_array[2]), 8, "0", STR_PAD_LEFT);
    $octet[3] = str_pad(decbin($address_array[3]), 8, "0", STR_PAD_LEFT);
    return implode($octet, ".");
  }


  function BinaryMask_To_CIDR($binary_mask){
    return substr_count($binary_mask, "1");
  }

  function SubnetMask_To_CIDR($subnet_mask){
    $binary_mask = $this->Decimal_To_Binary($subnet_mask);
    return $this->BinaryMask_To_CIDR($binary_mask);
  }

  function CIDR_To_BinaryMask($cidr) {
    $binary_string = "00000000000000000000000000000000";
    while($cidr > 0){
      $binary_string = substr_replace($binary_string, "1", ($cidr-1), 1);
      $cidr--;
    }
    return substr($binary_string,0,8).".".substr($binary_string,8,8).".".substr($binary_string,16,8).".".substr($binary_string,24,8);
  }

  function CIDR_To_SubnetMask($cidr){
    $binary_mask = $this->CIDR_To_BinaryMask($cidr);
    return $this->Binary_To_Decimal($binary_mask);
  }

  function Get_Network_Address($ip_address, $subnet_mask){
    $ip_array = explode(".", $ip_address);
    $sub_array = explode(".", $subnet_mask);
    $net_array[0] = (int)$ip_array[0] & (int)$sub_array[0];
    $net_array[1] = (int)$ip_array[1] & (int)$sub_array[1];
    $net_array[2] = (int)$ip_array[2] & (int)$sub_array[2];
    $net_array[3] = (int)$ip_array[3] & (int)$sub_array[3];
    return implode(".", $net_array);
  }

  function Get_Total_Hosts_From_CIDR($cidr){
    return pow(2,(32-$cidr));
  }

  function Get_Broadcast_From_NetworkCIDR($network_address, $cidr){
    $binary_string = ereg_replace("\.", "", $this->Decimal_To_Binary($network_address));
    $host_bits = 32 - $cidr;
    while($host_bits){
      $binary_string = substr_replace($binary_string, "1", -($host_bits), 1);
      $host_bits--;
    }
    return $this->Binary_To_Decimal(substr($binary_string,0,8).".".substr($binary_string,8,8).".".substr($binary_string,16,8).".".substr($binary_string,24,8));
  }

}
?>
