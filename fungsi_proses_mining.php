<?php

function proses_mining($db_object, $k=5) {
	//hapus table temporary jarak
	$db_object->db_query("TRUNCATE jarak");


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
    echo "<table border=1>";
    while ($row = $db_object->db_fetch_array($query)) {
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
