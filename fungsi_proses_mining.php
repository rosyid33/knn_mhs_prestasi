<?php
function proses_mining($db_object){
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
	$query=$db_object->db_query($sql);

	$jarak = array();
	$a = 0;
	//hitung jarak
	while($row = $db_object->db_fetch_array($query)){

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
		$query1=$db_object->db_query($sql1);
                $b = 0;
		while($row1 = $db_object->db_fetch_array($query1)){
			$jarak[$a][$b] = absolute($row['mk1']-$row1['mk1'])
						+ absolute($row['mk2']-$row1['mk2'])
						+ absolute($row['mk3']-$row1['mk3'])
						+ absolute($row['mk4']-$row1['mk4'])
						+ absolute($row['mk5']-$row1['mk5'])

						+ absolute($row['mk6']-$row1['mk6'])
						+ absolute($row['mk7']-$row1['mk7'])
						+ absolute($row['mk8']-$row1['mk8'])
						+ absolute($row['mk9']-$row1['mk9'])
						+ absolute($row['mk10']-$row1['mk10'])

						+ absolute($row['mk11']-$row1['mk11'])
						+ absolute($row['mk12']-$row1['mk12'])
						+ absolute($row['mk13']-$row1['mk13'])
						+ absolute($row['mk14']-$row1['mk14'])
						+ absolute($row['mk15']-$row1['mk15']);
			$b++;
		}
	    $a++;
	}	

	echo "<table border=1>";
	$a=0;
	while($a<count($jarak)){
		echo "<tr>";
                $b=0;
		while($b<count($jarak)){
			echo "<td>".$jarak[$a][$b]."</td>";
			$b++;
		}
		echo "</tr>";
		$a++;
	}
	echo "</table>";
}


function absolute($nilai){
	return ($nilai<0)?($nilai*-1):($nilai);
}