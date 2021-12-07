<?php


    // $url = 'http://opendata.busan.go.kr/openapi/service/GoodPriceStoreService/getGoodPriceStoreList'; 

    // $queryParams = '?' . urlencode('ServiceKey') . '='. ($ServiceKey); 
    // $queryParams .= '&' . urlencode('numOfRows') . '=' . urlencode('10'); 
    // $queryParams .= '&' . urlencode('pageNo') . '=' . urlencode('1'); 
    // $queryParams .= '&' . urlencode('typecode') . '=' . urlencode('602');


        $ch = curl_init();
        $url = 'http://api.seibro.or.kr/openapi/service/StockSvc/getKDRSecnInfo'; /*URL*/
        $ServiceKey='eo0HSipxpQ0Q0reG5TMV60XA3JlkgzU6EkS8LnOiNzMBXYNn32T62%2BvlhK0wqstGUZZRHpUL%2F0xGbkKzj0is2g%3D%3D';

        $queryParams = '?' . urlencode('serviceKey') .'=' .$ServiceKey; /*Service Key*/
        $queryParams .= '&' . urlencode('shortIsin') . '=' . urlencode('005930'); /**/
        $queryParams .= '&' . urlencode('numOfRows') . '=' . urlencode('2'); /**/
        $queryParams .= '&' . urlencode('pageNo') . '=' . urlencode('1'); /**/

        curl_setopt($ch, CURLOPT_URL, $url . $queryParams);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        $response = curl_exec($ch);
        curl_close($ch);

        var_dump($response);

//echo $urlDecode =urldecode("eo0HSipxpQ0Q0reG5TMV60XA3JlkgzU6EkS8LnOiNzMBXYNn32T62%2BvlhK0wqstGUZZRHpUL%2F0xGbkKzj0is2g%3D%3D");

// 일반 인증키
// (Encoding)	
// eo0HSipxpQ0Q0reG5TMV60XA3JlkgzU6EkS8LnOiNzMBXYNn32T62%2BvlhK0wqstGUZZRHpUL%2F0xGbkKzj0is2g%3D%3D
// eo0HSipxpQ0Q0reG5TMV60XA3JlkgzU6EkS8LnOiNzMBXYNn32T62%2BvlhK0wqstGUZZRHpUL%2F0xGbkKzj0is2g%3D%3D
// 일반 인증키
// (Decoding)	
// eo0HSipxpQ0Q0reG5TMV60XA3JlkgzU6EkS8LnOiNzMBXYNn32T62+vlhK0wqstGUZZRHpUL/0xGbkKzj0is2g==
// eo0HSipxpQ0Q0reG5TMV60XA3JlkgzU6EkS8LnOiNzMBXYNn32T62+vlhK0wqstGUZZRHpUL/0xGbkKzj0is2g==
?>
