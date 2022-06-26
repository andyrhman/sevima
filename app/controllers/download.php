<?php

//download.php

include('Vaksinku.php');

$object = new Vaksinku;

require_once('../../vendor/dompdf/pdf.php');

if(isset($_GET["id"]))
{
    $object->query = "
    SELECT * FROM pertemuan_vaksinasi 
    WHERE id_pertemuan = '".$_GET["id"]."'
    ";

    $data_pertemuan = $object->get_result();

	$html = '<table border="0" cellpadding="5" cellspacing="5" width="100%">';


    foreach($data_pertemuan as $row_pertemuan)
    {

        $object->query = "
        SELECT * FROM pengguna 
        WHERE id_pengguna = '".$row_pertemuan["id_pengguna"]."'
        ";

        $data_pasien = $object->get_result();

        $object->query = "
        SELECT * FROM jadwal_vaksin
        INNER JOIN jenis_vaksin 
        ON jenis_vaksin.id_vaksin = jadwal_vaksin.id_vaksin 
        INNER JOIN tempat_vaksin 
        ON tempat_vaksin.id_tempat = jadwal_vaksin.id_tempat 
        WHERE jadwal_vaksin.id_jadwal_vaksin = '".$row_pertemuan["id_jadwal_vaksin"]."'
        ";

        $data_vaksinasi = $object->get_result();


		$html .= '<span><img src="../../assets/img/logo-kemenkes.png" alt="Logo Kemenkes" width="150"><img src="../../assets/img/logo bpjs-02.png" alt="Logo Kemenkes" width="160"></span>';

        $html .= '<img src="../../assets/img/logo-germas.png" align="right" alt="Logo Germas" width="150"">';

        $html .= '<hr/>';

        $html .= '<h1 align="center"><b> Kartu Vaksinasi COVID-19 </b></h1>';
    
        $html .= '<span>';
        
        foreach($data_pasien as $row_data_pasien)
        {  
            $html .= '<h5 align="right">No. NIK: '.$row_data_pasien['nik'].' </h5>';
            $html .= '                                                
                <table border="0" cellpadding="5" cellspacing="5" width="80%">
                    <tr>
                        <th align="left" >No. Tiket</th>
                        <td>'.$row_pertemuan['no_pertemuan_vaksinasi'].'</td>
                    </tr>';
            $html .= '                                                        
                    <tr>
                        <th align="left" >Nama Lengkap</th>
                            <td>'.$row_data_pasien['nama_pengguna'].'</td>
                        </tr>
                    <tr>
                        <th align="left" >Tanggal Lahir</th>
                        <td>'.$row_data_pasien['tanggal_lahir'].'</td>
                    </tr>
                    <tr>
                        <th align="left" >No. HP</th>
                        <td>'.$row_data_pasien['nomor_hp'].'</td>
                    </tr>
                    <tr>
                        <th align="left" >Alamat</th>
                        <td>'.$row_data_pasien['alamat'].'</td>
                    </tr>';
        }

        foreach($data_vaksinasi as $row_data_vaksinasi)
        {
            $html .='<tr>
                        <th align="left" >Lokasi Menerima</th>
                        <td>'.$row_data_vaksinasi['nama_tempat'].'</td>
                    </tr>';
            $html .= '
                </table>
                </span>';

            $html .= '                                                
                <h1 align="center"><b>Riwayat Pemberian Vaksin Covid-19</b></h1>
                <table border="0" cellpadding="5" cellspacing="5" width="100%">
                    <tr style="background-color: #41aaf0; color: white;">
                        <th>Tanggal</th>
                        <th>Nama Vaksin</th>
                        <th>Lokasi</th>
                        <th>Dosis</th>
                    </tr>';
            $html .= '                                                        
                    <tr>
                        <td>'.$row_data_vaksinasi["jadwal_tanggal_vaksin"].'</td>
                        <td>'.$row_data_vaksinasi["nama_vaksin"].'</td>
                        <td>'.$row_data_vaksinasi["nama_tempat"].'</td>';

            if($row_pertemuan['sudah_vaksin_dosis_1'] == "Ya")
            {
                $html .= '<td>DOSIS 1 SELESAI RENCANA DOSIS 2 <br>'.$row_pertemuan["tanggal_pertemuan_berikutnya"].'</td>';
            }else 
            {
                $html .= '<td>Ke-1</td>';
            }

            $html .= '</tr>';

            if ($row_pertemuan['sudah_vaksin_dosis_2'] == "Ya") {
                $html .= '
                <tr>
                    <td>'.$row_pertemuan["tanggal_pertemuan_berikutnya"].'</td>
                    <td>'.$row_data_vaksinasi["nama_vaksin"].'</td>
                    <td>'.$row_data_vaksinasi["nama_tempat"].'</td>
                    <td>SELESAI DOSIS KEDUA</td>

                </tr>';
            }else {
                $html .= '                                                    
                <tr>
                    <td>'.$row_pertemuan["tanggal_pertemuan_berikutnya"].'</td>
                    <td>'.$row_data_vaksinasi["nama_vaksin"].'</td>
                    <td>'.$row_data_vaksinasi["nama_tempat"].'</td>
                    <td>Ke-2</td>

                </tr>';
            }

            $html .= '
                </table>';
                        
        }
        $html .= '<h4>Catatan:</h4>
                <p>Apabila terdapat gejala pasca dilakukan vaksinasi dapat menghubungi</p>
                <table border="0" cellpadding="5" cellspacing="5" width="50%" >
                    <tr>
                        <th align="left" >Nama</th>
                        <td>:</td>
                        <td>Andy Rahman</td>
                    </tr>
                    <tr>
                        <th align="left" >No Telp</th>
                        <td>:</td>
                        <td>08219369274</td>
                    </tr>

                </table>
                <br>
                <div align="center"><img src="../../assets/img/qrekemenkes.png" width="120" alt=""></div> ';
    }

	

	echo $html;

	$pdf = new Pdf();

	$pdf->loadHtml($html, 'UTF-8');
	$pdf->render();
	ob_end_clean();
	//$pdf->stream($_GET["id"] . '.pdf', array( 'Attachment'=>1 ));
	$pdf->stream($_GET["id"] . '.pdf', array( 'Attachment'=>false ));
	exit(0);

}

?>