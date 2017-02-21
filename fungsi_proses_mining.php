<?php

function proses_mining($db_object, $k=5) {
	//hapus table temporary jarak
	$db_object->db_query("TRUNCATE jarak");
        $db_object->db_query("DELETE FROM hasil");


    $sql = "SELECT
            period.`semester`,period.`tahun`,
            mhs.`nim`, mhs.`nama`,
              latih.*
            FROM
              data_latih latih,
              mahasiswa mhs,
              periode period
            WHERE latih.`id_mhs` = mhs.`id_mhs`
            AND period.`id_periode` = latih.`id_periode`";
    $query = $db_object->db_query($sql);

    $jarak = array();
    $a = 0;
    //hitung jarak
    echo "Jarak:";
    echo "<table border=1>";
    $temp_data_latih = array();
    while ($row = $db_object->db_fetch_array($query)) {
        $temp_data_latih[] = $row;
        echo "<tr>";
        $sql1 = "SELECT
                period.`semester`,period.`tahun`,
                mhs.`nim`, mhs.`nama`,
                  latih.*
                FROM
                  data_latih latih,
                  mahasiswa mhs,
                  periode period
                WHERE latih.`id_mhs` = mhs.`id_mhs`
                AND period.`id_periode` = latih.`id_periode`";
        $query1 = $db_object->db_query($sql1);
        $b = 0;
        while ($row1 = $db_object->db_fetch_array($query1)) {
            $jarak[$a][$b] = absolute($row['mk1'] - $row1['mk1']) +
                    absolute($row['mk2'] - $row1['mk2']) +
                    absolute($row['mk3'] - $row1['mk3']) +
                    absolute($row['mk4'] - $row1['mk4']) +
                    absolute($row['mk5'] - $row1['mk5']) +
                    absolute($row['mk6'] - $row1['mk6']) +
                    absolute($row['mk7'] - $row1['mk7']) +
                    absolute($row['mk8'] - $row1['mk8']) +
                    absolute($row['mk9'] - $row1['mk9']) +
                    absolute($row['mk10'] - $row1['mk10']) +
                    absolute($row['mk11'] - $row1['mk11']) +
                    absolute($row['mk12'] - $row1['mk12']) +
                    absolute($row['mk13'] - $row1['mk13']) +
                    absolute($row['mk14'] - $row1['mk14']) +
                    absolute($row['mk15'] - $row1['mk15']);
            echo "<td>" . $jarak[$a][$b] . "</td>";
            $b++;
        }
        echo "</tr>";
        $a++;
    }
    echo "</table>";
    
    //ambill sebanyak k terkecil dari jarak
    $a=0;
    $jarak_k_terkecil = array();
    while ($a < count($jarak)) {
        $jarak_k_terkecil[$a] = get_jarak_terkecil_sebanyak_k($jarak[$a], $k);
        $a++;
    }
    
    //hitung average tiap jarak data
    $average_tiap_jarak = array();
    $a=0;
    while ($a < count($jarak_k_terkecil)) {
        $average_tiap_jarak[$a] = average($jarak_k_terkecil[$a]);
        $a++;
    }
    
    //average from all average...
    $average_all_avg_jarak = average($average_tiap_jarak);
    
    //standard deviasi
    $std_deviasi1 = array();//pengurangan pangkat 2
    $a=0;
    while($a < count($average_tiap_jarak)){
        $std_deviasi1[$a] = pow($average_tiap_jarak[$a] - $average_all_avg_jarak,2);
        $a++;
    }
    
    $std_deviasi2 = array_sum($std_deviasi1);
    $std_deviasi3 = $std_deviasi2/(count($std_deviasi1)-1);
    $stdDeviasi = sqrt($std_deviasi3);
    
    $treshold = $average_all_avg_jarak+($stdDeviasi*3);//3 itu apa???
    echo "Treshold = ".price_format($treshold);
    //
    
    //hitung nilai rata-rata nilai mahasiswa per mata kuliah
    $sql = "SELECT "
            . "AVG(mk1) AS mk1, "
            . "AVG(mk2) AS mk2, "
            . "AVG(mk3) AS mk3, "
            . "AVG(mk4) AS mk4, "
            . "AVG(mk5) AS mk5, "
            . "AVG(mk6) AS mk6, "
            . "AVG(mk7) AS mk7, "
            . "AVG(mk8) AS mk8, "
            . "AVG(mk9) AS mk9, "
            . "AVG(mk10) AS mk10, "
            . "AVG(mk11) AS mk11, "
            . "AVG(mk12) AS mk12, "
            . "AVG(mk13) AS mk13, "
            . "AVG(mk14) AS mk14, "
            . "AVG(mk15) AS mk15 "
            . " FROM data_latih ";
    $query = $db_object->db_query($sql);
    
    br();
    echo "Rata-rata per mata kuliah:";
    echo "<table class='table table-bordered table-striped  table-hover'>";
    echo "<tr>";
        echo "<td>MK_1</td><td>MK_2</td><td>MK_3</td><td>MK_4</td><td>MK_5</td>
                <td>MK_6</td><td>MK_7</td><td>MK_8</td><td>MK_9</td><td>MK_10</td>
                <td>MK_11</td><td>MK_12</td><td>MK_13</td><td>MK_14</td><td>MK_15</td>";
    echo "</tr>";
    $row = $db_object->db_fetch_array($query);
    $var_average_matkul = $row;
        echo "<tr>";
            echo "<td>".price_format($row['mk1'])."</td>";
            echo "<td>".price_format($row['mk2'])."</td>";
            echo "<td>".price_format($row['mk3'])."</td>";
            echo "<td>".price_format($row['mk4'])."</td>";
            echo "<td>".price_format($row['mk5'])."</td>";
            echo "<td>".price_format($row['mk6'])."</td>";
            echo "<td>".price_format($row['mk7'])."</td>";
            echo "<td>".price_format($row['mk8'])."</td>";
            echo "<td>".price_format($row['mk9'])."</td>";
            echo "<td>".price_format($row['mk10'])."</td>";
            echo "<td>".price_format($row['mk11'])."</td>";
            echo "<td>".price_format($row['mk12'])."</td>";
            echo "<td>".price_format($row['mk13'])."</td>";
            echo "<td>".price_format($row['mk14'])."</td>";
            echo "<td>".price_format($row['mk15'])."</td>";
        echo "</tr>";
    echo "</table>";
    
    foreach ($temp_data_latih as $key => $value) {
        $kurang = $lebih = 0;
        
        $hasil_mk1 = ($value['mk1']<=$var_average_matkul['mk1'])?"KURANG":"LEBIH";
        $hasil_mk2 = ($value['mk2']<=$var_average_matkul['mk2'])?"KURANG":"LEBIH";
        $hasil_mk3 = ($value['mk3']<=$var_average_matkul['mk3'])?"KURANG":"LEBIH";
        $hasil_mk4 = ($value['mk4']<=$var_average_matkul['mk4'])?"KURANG":"LEBIH";
        $hasil_mk5 = ($value['mk5']<=$var_average_matkul['mk5'])?"KURANG":"LEBIH";
        
        $hasil_mk6 = ($value['mk6']<=$var_average_matkul['mk6'])?"KURANG":"LEBIH";
        $hasil_mk7 = ($value['mk7']<=$var_average_matkul['mk7'])?"KURANG":"LEBIH";
        $hasil_mk8 = ($value['mk8']<=$var_average_matkul['mk8'])?"KURANG":"LEBIH";
        $hasil_mk9 = ($value['mk9']<=$var_average_matkul['mk9'])?"KURANG":"LEBIH";
        $hasil_mk10 = ($value['mk10']<=$var_average_matkul['mk10'])?"KURANG":"LEBIH";
        
        $hasil_mk11 = ($value['mk11']<=$var_average_matkul['mk11'])?"KURANG":"LEBIH";
        $hasil_mk12 = ($value['mk12']<=$var_average_matkul['mk12'])?"KURANG":"LEBIH";
        $hasil_mk13 = ($value['mk13']<=$var_average_matkul['mk13'])?"KURANG":"LEBIH";
        $hasil_mk14 = ($value['mk14']<=$var_average_matkul['mk14'])?"KURANG":"LEBIH";
        $hasil_mk15 = ($value['mk15']<=$var_average_matkul['mk15'])?"KURANG":"LEBIH";
        
        ($hasil_mk1=="KURANG")?$kurang++:$lebih++;
        ($hasil_mk2=="KURANG")?$kurang++:$lebih++;
        ($hasil_mk3=="KURANG")?$kurang++:$lebih++;
        ($hasil_mk4=="KURANG")?$kurang++:$lebih++;
        ($hasil_mk5=="KURANG")?$kurang++:$lebih++;
        
        ($hasil_mk6=="KURANG")?$kurang++:$lebih++;
        ($hasil_mk7=="KURANG")?$kurang++:$lebih++;
        ($hasil_mk8=="KURANG")?$kurang++:$lebih++;
        ($hasil_mk9=="KURANG")?$kurang++:$lebih++;
        ($hasil_mk10=="KURANG")?$kurang++:$lebih++;
        
        ($hasil_mk11=="KURANG")?$kurang++:$lebih++;
        ($hasil_mk12=="KURANG")?$kurang++:$lebih++;
        ($hasil_mk13=="KURANG")?$kurang++:$lebih++;
        ($hasil_mk14=="KURANG")?$kurang++:$lebih++;
        ($hasil_mk15=="KURANG")?$kurang++:$lebih++;
        
        $hasilAkhir = ($kurang>=$lebih)?"BERMASALAH":"BERPRESTASI";
        
        $table = "hasil";
        $field_value = array("id_mhs"=>$value['id_mhs'],
            "id_periode"=>$value['id_periode'],
            "mk1"=>$hasil_mk1,
            "mk2"=>$hasil_mk2,
            "mk3"=>$hasil_mk3,
            "mk4"=>$hasil_mk4,
            "mk5"=>$hasil_mk5,
            "mk6"=>$hasil_mk6,
            "mk7"=>$hasil_mk7,
            "mk8"=>$hasil_mk8,
            "mk9"=>$hasil_mk9,
            "mk10"=>$hasil_mk10,
            "mk11"=>$hasil_mk11,
            "mk12"=>$hasil_mk12,
            "mk13"=>$hasil_mk13,
            "mk14"=>$hasil_mk14,
            "mk15"=>$hasil_mk15,
            "hasil"=>$hasilAkhir
                );
        $query = $db_object->insert_record($table, $field_value);
    }
    
    
    $sql = "SELECT
            period.`semester`,period.`tahun`,
            mhs.`nim`, mhs.`nama`,
              hasil.*
            FROM
              hasil hasil,
              mahasiswa mhs,
              periode period
            WHERE hasil.`id_mhs` = mhs.`id_mhs`
            AND period.`id_periode` = hasil.`id_periode`";
    $query = $db_object->db_query($sql);
    br();
    echo "Hasil:";
    echo "<table class='table table-bordered table-striped  table-hover'>";
    echo "<tr>";
        echo "<th>No</th><th>NIM</th><th>Periode</th>
            <th>MK_1</th><th>MK_2</th><th>MK_3</th><th>MK_4</th><th>MK_5</th>
                <th>MK_6</th><th>MK_7</th><th>MK_8</th><th>MK_9</th><th>MK_10</th>
                <th>MK_11</th><th>MK_12</th><th>MK_13</th><th>MK_14</th><th>MK_15</th>
                <th>Hasil</th>";
    echo "</tr>";
    $no=1;
    while ($row = $db_object->db_fetch_array($query)) {
        echo "<tr>";
            echo "<td>$no</td>";
            echo "<td>".$row['nim']."</td>";
            echo "<td>".$row['semester']." - ".$row['tahun']."</td>";
            echo "<td>".$row['mk1']."</td>";
            echo "<td>".$row['mk2']."</td>";
            echo "<td>".$row['mk3']."</td>";
            echo "<td>".$row['mk4']."</td>";
            echo "<td>".$row['mk5']."</td>";
            echo "<td>".$row['mk6']."</td>";
            echo "<td>".$row['mk7']."</td>";
            echo "<td>".$row['mk8']."</td>";
            echo "<td>".$row['mk9']."</td>";
            echo "<td>".$row['mk10']."</td>";
            echo "<td>".$row['mk11']."</td>";
            echo "<td>".$row['mk12']."</td>";
            echo "<td>".$row['mk13']."</td>";
            echo "<td>".$row['mk14']."</td>";
            echo "<td>".$row['mk15']."</td>";
            echo "<td>".$row['hasil']."</td>";
        echo "</tr>";
        $no++;
    }
    echo "</table>";
}



function absolute($nilai) {
    return ($nilai < 0) ? ($nilai * -1) : ($nilai);
}

function get_jarak_terkecil_sebanyak_k($data, $k){
    $return = array();
    $x=0;
    while($x<$k){
        $min = min($data);
        if($min>0){
            $return[] = $min;
            $x++;
        }
        //$data = array_diff($data, [$min]);
        if(($key = array_search($min, $data)) !== false) {
            unset($data[$key]);
        }
    }
    return $return;
}

function average($nilai){
    $a = array_sum($nilai);
    $b = count($nilai);
    return  $a/$b;
}
