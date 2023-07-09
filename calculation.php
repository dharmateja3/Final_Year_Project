<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js" integrity="sha384-qKXV1j0HvMUeCBQ+QVp7JcfGl760yU08IQ+GpUo5hlbpg51QRiuqHAJz8+BrxE/N" crossorigin="anonymous"></script>
    <title>Result Page</title>
    <style>
        body{
            margin:50px;
            border: transparent solid;
        }
        .head{
            color: blue;
        }
        .styled {

            color: black;
            font-size: medium;
        }
        h1{
            color:black;
            font-family: Arial, Helvetica, sans-serif;
        }
    </style>
</head>
<body>
<center><h1> OUTPUT REPORT </h1></center>

<?php
    include 'php/db.php';

    if(isset($_POST['submit']))
    {
    $ay = $_POST['ayacut'];
    $du = $_POST['duty'];
    $tw = $_POST['topwidth'];
    $tl = $_POST['toplevel'];
    $gl = $_POST['groundlevel'];
    $hf = $_POST['hardfoundation'];
    $si = $_POST['sill'];
    $mw = $_POST['max_water'];
    $ft = $_POST['ftl'];
    $al = $_POST['avglowwater'];
    $cb = $_POST['channelbed'];
    $fs = $_POST['fsl'];
    $bw = $_POST['bedwidth'];
    $ssl = $_POST['sideslopelevel'];

    $query = "INSERT INTO givendata (ayacut, duty, topWidth, topLevel, groundLevel, hardFoundation, sill, maxWater, fullTankLevel, avgLowWaterLevel, channelBed, fullSupplyLevel, bedWidth, sideslopelevel) VALUES ('{$ay}','{$du}','{$tw}','{$tl}','{$gl}','{$hf}','{$si}','{$mw}','{$ft}','{$al}','{$cb}','{$fs}','{$bw}','{$ssl}')";
    $data = mysqli_query($conn,$query);
    } 
    
    $cal = "SELECT ayacut, duty, topWidth, topLevel, groundLevel, hardFoundation, sill, maxWater, fullTankLevel, avgLowWaterLevel, channelBed, fullSupplyLevel, bedWidth, sideSlopeLevel FROM givendata";
    $result = mysqli_query($conn,$cal);
    $row = mysqli_fetch_assoc($result);

    $ay = $row['ayacut'];
    $duty = $row['duty'];
    $tw = $row['topWidth'];
    $tl = $row['topLevel'];
    $gl = $row['groundLevel'];
    $hf = $row['hardFoundation'];
    $sl = $row['sill'];
    $mw = $row['maxWater'];
    $ftl = $row['fullTankLevel'];
    $alw = $row['avgLowWaterLevel'];
    $cb = $row['channelBed'];
    $fsl = $row['fullSupplyLevel'];
    $bw = $row['bedWidth'];
    $ssl = $row['sideSlopeLevel'];
//discharge
    $disc = $ay/$duty;
    $discharge = number_format($disc,2);
    $head_causing = $alw - $sl;
    $min_driv_head = 0.25;
    echo "<h3 class = 'head'>"."1. Discharge : </h3>";
    echo "<p class = 'styled'>" . "Discharge : $discharge cumec" . "</p>";
//Vent-Way
    $cd = 0.60;
    $g = 9.81;
    $val = 2*$g*$min_driv_head;
    $va = $cd*sqrt($val);
    $area = $discharge/$va;
    $area_part = floor($area);
    $decimal_point = number_format($area - $area_part, 3, '.', '.');
    $Area_vent = $area_part.'.'.substr($decimal_point,2);
    $val2 = 4*$Area_vent/3.14;
    $dia = sqrt($val2);
    $dia_part = floor($dia);
    $deci_point = number_format($dia - $dia_part, 2, '.', '.');
    $diap = $dia_part.'.'.substr($deci_point,2);
    if($diap==0.44){
        $diap=0.45;
    }
    $diaphragm = $diap;
    $barrel_width = $diaphragm+$diaphragm/3;
    $barrel_depth = $diaphragm+$diaphragm*2/3;
    echo "<h3 class = 'head'>"."2. Vent Way : </h3>";
    echo  "<p class = 'styled'>" . "Area of the Vent Way : $Area_vent sq.m"  . "</p>";
    echo  "<p class = 'styled'>" . "Diameter of the diaphragm : $diaphragm m"  . "</p>";
    echo  "<p class = 'styled'>" . "Width of the barrel : $barrel_width m"  . "</p>";
    echo  "<p class = 'styled'>" . "Depth of the barrel : $barrel_depth m"  . "</p>";
//Sluice Barrel
 echo "<h3 class = 'head'>"."3. Sluice Barrel : </h3>";
    $clear_span = $barrel_width;
    $conc_thick = 0.10;
    $sidewall_found = $cb - ($hf-$conc_thick);
    echo  "<p class = 'styled'>" . "Side wall foundation : $sidewall_found m"  . "</p>";
//RCC Slab
echo "<h3 class = 'head'>"."4. R.C.C. Slab : </h3>";
    //Self-Weight
    $slab_thickness = 0.15;
    $sp_wt_conc = 25;
    $effective_span = $barrel_width + $slab_thickness;
    $self_weight = $sp_wt_conc*$slab_thickness*$effective_span*1;
    echo  "<p class = 'styled'>" . "Slab Thickness : $slab_thickness m"  . "</p>";
    echo  "<p class = 'styled'>" . "Effective Span : $effective_span m"  . "</p>";

    //Weight of Earth Over the Slab(Weight of Over burden)
    $bank_height_over_slab = $tl - ($cb+$barrel_depth+$slab_thickness);
    $sp_wt_saturated_earth = 22.4;
    $wt_earth = $sp_wt_saturated_earth*$bank_height_over_slab*$effective_span;
    $total_wt = $wt_earth+$self_weight;
    $bm = $total_wt*$effective_span/8;
    echo  "<p class = 'styled'>" . "Height of the bank over the slab : $bank_height_over_slab m"  . "</p>";
    //Using M20 Grade Concerte and Fe415 Steel
    $R = 0.138*20000;
    $D = $bm/($R*1);//unit width = 1
    $dp = sqrt($D);
    $dp_part = floor($area);
    $decim_point = number_format($dp - $dp_part, 3, '.', '.');
    $d = $dp_part.'.'.substr($decim_point,2);
    $effective_cover = 0.025;
    $Overall_Depth = $d+$effective_cover;
    if($Overall_Depth<0.15){
        $Overall_Depth=0.15;
    }
    echo  "<p class = 'styled'>" . "Effective Depth : $d m"  . "</p>";
    echo  "<p class = 'styled'>" . "Overall Depth : $Overall_Depth m"  . "</p>";
    //Side Walls
    echo "<h3 class = 'head'>"."5. Side Walls : </h3>";
    //Assuming the botttom and top width as 1m and 0.45m respectively
    $btm_width = 1;
    $top_width = 0.45;
    echo  "<p class = 'styled'>" . "Top width of the side wall : $top_width m"  . "</p>";
    echo  "<p class = 'styled'>" . "Bottom width of the side wall : $btm_width m"  . "</p>";
    //Earth Pressure(H)
    $earth_fill_height = $tl - $cb;
    $repose_angle = 30;
    $angle_radians = deg2rad($repose_angle);
    $sine  = sin($angle_radians);
    $earth_pressure_A = $sp_wt_saturated_earth*$earth_fill_height*((1-$sine)/(1+$sine));
    $earth_pressure_C = $sp_wt_saturated_earth*$bank_height_over_slab*((1-$sine)/(1+$sine));
    $horizontal_thrust_side_wall = ($earth_pressure_A+$earth_pressure_C)/2*$effective_span;
    $acting_height = ($effective_span/3)*(((2*$earth_pressure_C)+$earth_pressure_A)/($earth_pressure_C+$earth_pressure_A));
    //Weight transmitted by the roof slab(P1)
    $load_Each_wall_P1 = $total_wt/2;
    $P1_length = $slab_thickness/2;
    //Weigtht of the earth in portion CDEF(P2)
    $top_width_CtoD = $top_width - $slab_thickness;
    $earth_standing_height = $bank_height_over_slab;
    $Earth_wt_P2 = $top_width_CtoD*$earth_standing_height*1*$sp_wt_saturated_earth;
    $P2_length = $slab_thickness+($top_width_CtoD/2);
    //Weight of the earth in portion BCFG(P3)
    $BC_width = $btm_width-$top_width;
    $earth_height = $tl-($cb+$effective_span);
    $earth_wt_P3 = $BC_width*$earth_height*1*$sp_wt_saturated_earth;
    $P3_length = $top_width+($BC_width/2);
    //Weight of earth in portion ABC(P4)
    $earth_height_P4 = ($cb+$effective_span)-$cb;
    $earth_weight_P4 = $BC_width*$earth_height_P4*1*$sp_wt_saturated_earth;
    $P4_length = $top_width+(2/3*$BC_width);
    //Weight of masonary side wall (P5)
    $sp_wt_masonary = 21;
    $area_wall = (($top_width+$btm_width)/2)*$earth_height_P4;
    $P5 = $area_wall*1*$sp_wt_masonary;
    $P5_length = ($earth_height_P4/3)*(($btm_width+(2*$top_width))/($btm_width+$top_width));
    //Stability Analysis 
    $P1_moment = $load_Each_wall_P1*$P1_length;
    $P2_moment = $Earth_wt_P2*$P2_length;
    $P3_moment = $earth_wt_P3*$P3_length;
    $P4_moment = $earth_weight_P4*$P4_length;
    $P5_moment = $P5*$P5_length;
    $H_moment = $horizontal_thrust_side_wall*(-$acting_height);

    //Calculating Moments
    $total_moment =  $P1_moment+ $P2_moment+ $P3_moment+ $P4_moment+ $P5_moment+$H_moment;
    $total_vertical_force = $load_Each_wall_P1+$Earth_wt_P2+$earth_wt_P3+$earth_weight_P4+$P5;
    $resultant_toe =$total_moment/$total_vertical_force;

    $allow_eccentricity = ($btm_width/6);
    $eccentricity = ($btm_width/2)-$resultant_toe;

    if($eccentricity>$allow_eccentricity){
        echo  "<p class = 'styled'>" . "The resultant is outside of the middle third.";"</p>";
    }
    $max_compression_toe = ($total_vertical_force/(1*1))*(1+((6*$eccentricity)/1));
    if($max_compression_toe<3000){
        $tension_at_A = ($total_vertical_force/(1*1))*(1-((6*$eccentricity)/1));
    if($tension_at_A<125){
        echo  "<p class = 'styled'>" . "The assumed section is Safe and can be adopted."  . "</p>";
    }
    else{
        echo  "<p class = 'styled'>" . "The section is not Safe."  . "</p>";
    }
    }

    //Tower Head
    echo "<h3 class = 'head'>"."6. Tower Head : </h3>";
    $top_level_well = $mw+0.3;
    $btm_level_well = $cb;
    $height_well = $top_level_well-$btm_level_well;
    $inner_dia = 1.25;
    echo  "<p class = 'styled'>" . "The top level of the well : + $top_level_well "  . "</p>";
    echo  "<p class = 'styled'>" . "The bottom level of the well : + $btm_level_well "  . "</p>";
    echo  "<p class = 'styled'>" . "The height of the well : $height_well m"  . "</p>";
    
    //Downstream Cistern 
    echo "<br><br><h3 class = 'head'>"."7. Downstream Cistern : </h3>";
    $top_level_cistern = $ssl;
    $btm_level = $cb;
    $height_of_wall = $top_level_cistern-$btm_level;
    $top_thickness_wall = 0.5;
    $btm_thickness_wall = 0.4*$height_of_wall;

    echo  "<p class = 'styled'>" . "The top level of the cistern : + $top_level_cistern"  . "</p>";
    echo  "<p class = 'styled'>" . "The bottom level of the cistern : + $btm_level"  . "</p>";
    echo  "<p class = 'styled'>" . "Height of the wall : $height_of_wall m"  . "</p>";
    echo  "<p class = 'styled'>" . "Top thickness of the wall : $top_thickness_wall m"  . "</p>";
    echo  "<p class = 'styled'>" . "Bottom_thickness of the wall : $btm_thickness_wall m"  . "</p>";

    //Talus
    echo "<h3 class = 'head'>"."8. Talus : </h3>";
    echo  "<p class = 'styled'>" . "Length of the talus is considered as 3m to 5m."  . "</p>";

    $query = "truncate table givendata";
    $data = mysqli_query($conn,$query);
    

?>
<center><button onclick="printPage()" type="button" class="btn">Download</button></center>
<style>
.btn{
    background-color: greenyellow;
    color: #fff;
    border-radius: 5px;
    display: inline-block;
    width: 100px;
    height: 40px;
    font-size: 17px;
    cursor: pointer;
}
.btn::hover{
    background-color:green;
}
</style>
<script>
		function printPage() {
			window.print(); // This will trigger the print functionality of the browser
		}
</script>
</body>
</html>