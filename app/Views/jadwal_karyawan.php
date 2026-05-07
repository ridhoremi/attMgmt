<div class="container-fluid py-4 px-4" style="margin-top:50px;">
    <div class="row">
        <div class="col">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-3">Jadwal Karyawan</h5>
                </div>
                 <div class="card-body">
                </div>
            </div>
            <div class="card card-custom p-3 mb-3 mt-4">
        <div class="table-responsive">

        <table class="table table-bordered ">

            <thead class="table-dark">

            <tr>

                <th class="nama-col" style="text-align:left;">Nama Karyawan</th>

                <?php
                $jumlahHari = date('t', strtotime("$tahun-$bulan-01"));

                for ($i = 1; $i <= $jumlahHari; $i++): ?>
                    <th class="text-center">
                     <?= $i ?>
                     </th>
                <?php endfor; ?>

            </tr>

            </thead>

            <?php foreach ($karyawan as $k): ?>
                <tr>
                    <td class="nama-col text-start">
                    <?= $k['nama'] ?>
                    </td>
            <?php for ($i = 1; $i <= $jumlahHari; $i++): ?>
                   <td class="text-center">-</td>
            <?php endfor; ?>
                </tr>
            <?php endforeach; ?>
            </table>
            </div>
        </div>
    </div>
</div>




    <!-- <script>
    // ================= HEADER =================
    let header = document.getElementById("header-row");

    for (let i = 1; i <= 31; i++) {
        let th = document.createElement("th");
        th.innerText = i;
        header.appendChild(th);
    }

    // ================= DATA =================
    const karyawan = ["Andi", "Budi", "Citra", "Dedi"];
    let body = document.getElementById("body-table");

    karyawan.forEach(nama => {
        let tr = document.createElement("tr");

        // Nama
        let tdNama = document.createElement("td");
        tdNama.className = "nama-col text-start";
        tdNama.innerText = nama;
        tr.appendChild(tdNama);

        // Tanggal
        for (let i = 1; i <= 31; i++) {

            let td = document.createElement("td");

            let shift = ["P", "S", "M", ""];
            let val = shift[Math.floor(Math.random() * shift.length)];

            td.innerText = val;

            if (val === "P") td.classList.add("bg-pagi");
            if (val === "S") td.classList.add("bg-siang");
            if (val === "M") td.classList.add("bg-malam");

            tr.appendChild(td);
        }

        body.appendChild(tr);
    });
</script> -->