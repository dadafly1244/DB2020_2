<!DOCTYPE html>
<html lang="ko">
<head>
<title>병원위치</title>
<meta charset = 'utf-8'>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<script type="text/javascript" src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
<script type="text/javascript" src="http://maps.google.com/maps/api/js?key=AIzaSyAolq9ku2eOi69tH9rhsMDkELmp4GIe9yc" >//키를 발급받아 사용하세요</script>
<style>
#map_ma {width:100%; height:400px; clear:both; border:solid 1px red;}
</style>
</head>
<body>
<div id="map_ma"></div>
<?php
			require_once 'dbconfig.php';
?>
<?php
   #병원 id 받아오기
    echo $_GET['hospital_id'];
    $get_hospital_id=$_GET['hospital_id'];
    $sql = "select hospital_name as name, hospital_latitude as lat, hospital_longitude as lon from HOSPITAL where  hospital_id= $get_hospital_id;";
    #echo $sql;
    $result = mysqli_query($link, $sql);
    $data = mysqli_fetch_assoc($result);
    
    
    

?>
<script type="text/javascript">
      $(document).ready(function() {
         var myLatlng = new google.maps.LatLng( "<?=  $data['lat'] ?>", "<?=  $data['lon'] ?>"); // 위치값 위도 경도
   var Y_point         = <?=  $data['lat'] ?>;      // Y 좌표
   var X_point         = <?=  $data['lon'] ?>;      // X 좌표
   var zoomLevel      = 18;            // 지도의 확대 레벨 : 숫자가 클수록 확대정도가 큼
   var markerTitle      = "대구광역시";      // 현재 위치 마커에 마우스를 오버을때 나타나는 정보
   var markerMaxWidth   = 300;            // 마커를 클릭했을때 나타나는 말풍선의 최대 크기
   
// 말풍선 내용 병원 명 표시하기 
   var h_name    = "<?=  $data['name'] ?>";  //javascript는 var 변수명 = "문자열내용"; ""빼먹지 말기!!!!!! qkf
   print(h_name);
   var contentString   = '<div>' +
   '<h2>'+h_name+'</h2>'+
   '<p>안녕하세요. 구글지도입니다.</p>' +
   
   '</div>';
   var myLatlng = new google.maps.LatLng(Y_point, X_point);
   var mapOptions = {
                  zoom: zoomLevel,
                  center: myLatlng,
                  mapTypeId: google.maps.MapTypeId.ROADMAP
               }
   var map = new google.maps.Map(document.getElementById('map_ma'), mapOptions);
   var marker = new google.maps.Marker({
                                 position: myLatlng,
                                 map: map,
                                 title: markerTitle
   });
   var infowindow = new google.maps.InfoWindow(
                                    {
                                       content: contentString,
                                       maxWizzzdth: markerMaxWidth
                                    }
         );
   google.maps.event.addListener(marker, 'click', function() {
      infowindow.open(map, marker);
   });
});
      </script>
</body>
</html>