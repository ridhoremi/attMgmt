 <div class="table-responsive">
     <table class="table table-bordered">

         <thead class="table-dark">

             <tr>

                 <th>Nama Karyawan</th>

                 <?php
                    $jumlahHari = date('t', strtotime("$tahun-$bulan-01"));

                    for ($i = 1; $i <= $jumlahHari; $i++): ?>

                     <th class="text-center">
                         <?= $i ?>
                     </th>

                 <?php endfor; ?>

             </tr>

         </thead>

         <tbody>

             <?php foreach ($karyawan as $k): ?>

                 <tr>

                     <td>
                         <?= esc($k['nama']) ?>
                     </td>

                     <?php for ($i = 1; $i <= $jumlahHari; $i++): ?>

                         <?php

                            $tanggal = sprintf(
                                '%04d-%02d-%02d',
                                $tahun,
                                $bulan,
                                $i
                            );

                            $shift = $map[$k['user_id']][$tanggal] ?? '-';

                            ?>

                         <td class="text-center">
                             <?= esc($shift) ?>
                         </td>

                     <?php endfor; ?>

                 </tr>

             <?php endforeach; ?>

         </tbody>

     </table>
 </div>