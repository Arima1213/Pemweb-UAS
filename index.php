<?php
session_start();
if (!isset($_SESSION['username'])) {
  header('Location: login.php');
  exit();
}

$username = $_SESSION['username'];

require_once "koneksi.php";

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Bootstrap demo</title>
  <link rel="stylesheet" href="bootstrap/dist/css/bootstrap.min.css" />
  <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
  <link rel="stylesheet" href="css/style.css" />
  <link rel="stylesheet" href="css/styleindex.css" />
</head>

<body>
  <script>
    AOS.init();
  </script>
  <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
    <div class="container">
      <a class="navbar-brand" href="index.php"><span class="text-warning">TAKAFUL</span>INDONESIA</a>
      <button aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation" class="navbar-toggler" data-bs-target="#navbarSupportedContent" data-bs-toggle="collapse" type="button">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link" href="index.php">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="index.php#about">About</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="index.php#urgent">Urgent</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="index.php#project">Project</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="index.php#benefit">Benefits</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="index.php#guide">Guide</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="faq.php">Faq</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="profilepage.php">
              <?php echo  $username;
              ?>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="profilepage.php">
              <?php

              // Query untuk mengambil data user berdasarkan username
              $query = "SELECT foto_profil FROM users WHERE username = '$username'";
              $result = mysqli_query($conn, $query);

              if ($result) {
                if (mysqli_num_rows($result) > 0) {
                  $row = mysqli_fetch_assoc($result);
                  $foto_profil = $row['foto_profil'];

                  // Gunakan nilai foto_profil dalam tag <img> atau tempat lain yang sesuai
                  echo '<img src="src/img_profil_user/' . $foto_profil . '" alt="Foto Profil" width="30" height="30" class="rounded-circle">';
                } else {
                  echo "Data tidak ada";
                }
              } else {
                echo "Query execution failed: " . mysqli_error($conn);
              }
              ?>
            </a>
          </li>
        </ul>
      </div>
    </div>
  </nav>



  <section class="section1" style="margin-top: 60px; overflow: hidden;">
    <div class="hero container-fluid vh-100">
      <div class="row align-items-center  px-3">
        <div class="col-6">
          <h1 data-aos-offset="-40" data-aos-easing="ease-in-out" data-aos-mirror="true" data-aos-once="false" data-aos-anchor-placement="center-center" data-aos="fade-right" data-aos-duration="1000" class="py-auto h-100">Menggenggam <span class="text-warning">Harapan</span>,
            <br>
            Mengalirkan <span class="text-info">Bantuan</span>,
            <br>
            bagi Masyarakat yang Membutuhkan
            <br>
            <a href="#" class="btn btn-outline-primary">Donasi Sekarang</a>
          </h1>
        </div>
        <div class="col-6">
          <div data-aos-easing="ease-in-out" data-aos-mirror="true" data-aos-once="false" class="hiasan-tiga" data-aos="zoom-in-left" data-aos-delay="500" data-aos-duration="1000">
            <lottie-player src="https://assets7.lottiefiles.com/packages/lf20_t9amg50m.json" background="transparent" speed="1" style="width: 100px; height: 100px;" loop autoplay></lottie-player>
          </div>
          <div data-aos-easing="ease-in-out" data-aos-mirror="true" data-aos-once="false" class="hiasan-dua" data-aos="zoom-in-left" data-aos-delay="500" data-aos-duration="1000">
            <lottie-player src="https://assets10.lottiefiles.com/packages/lf20_e3WEvmyKZq.json" background="transparent" speed="1" style="width: 200px; height: 200px;" loop autoplay></lottie-player>
          </div>
          <div data-aos-easing="ease-in-out" data-aos-mirror="true" data-aos-once="false" class="hiasan-satu" data-aos="zoom-in-left" data-aos-offset="30" data-aos-delay="500" data-aos-duration="300">
            <lottie-player src="https://assets10.lottiefiles.com/packages/lf20_3q62iymm.json" background="transparent" speed="1" style="width: 500px; height: 500px; " loop autoplay></lottie-player>
          </div>
          <div data-aos-easing="ease-in-out" data-aos-mirror="true" data-aos-once="false" class="gede" data-aos="fade-left" data-aos-delay="50" data-aos-duration="700">
            <lottie-player autoplay loop mode="normal" src="https://assets7.lottiefiles.com/packages/lf20_nnhtoiod.json" style="width: 600px"></lottie-player>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- end hero -->

  <section id="about" class="section2 my-2 w-100">
    <div class="isisection2 py-3 mx-5 text-center">
      <h2>Tentang Takaful</h2>
      <div class="gambar row">
        <img data-aos="fade-up" data-aos-offset="-500" data-aos-delay="0" data-aos-duration="1000" data-aos-easing="ease-in-out" data-aos-mirror="true" data-aos-once="false" data-aos-anchor-placement="center-center" class="col" src="src/images/image 31.png" alt="" />
        <img data-aos="fade-up" data-aos-offset="-500" data-aos-delay="250" data-aos-duration="1000" data-aos-easing="ease-in-out" data-aos-mirror="true" data-aos-once="false" data-aos-anchor-placement="center-center" class="col" src="src/images/image 32.png" alt="" />
        <img data-aos="fade-up" data-aos-offset="-500" data-aos-delay="500" data-aos-duration="1000" data-aos-easing="ease-in-out" data-aos-mirror="true" data-aos-once="false" data-aos-anchor-placement="center-center" class="col" src="src/images/image 33.png" alt="" />
      </div>
      <div class="my-3">
        <p data-aos="fade-up" data-aos-offset="-500" data-aos-delay="0" data-aos-duration="1000" data-aos-easing="ease-in-out" data-aos-mirror="true" data-aos-once="false" data-aos-anchor-placement="center-center">
          "Takaful" adalah sebuah platform website yang bertujuan untuk memfasilitasi kegiatan
          kemanusiaan dan saling peduli di antara para pengguna. Dengan fitur-fitur yang
          lengkap, Takaful menjadi tempat yang ideal bagi individu, kelompok, dan organisasi
          yang ingin berkontribusi dalam membantu sesama. Dengan fitur : Transaksi donasi,
          Laporan keuangan.
        </p>
      </div>
    </div>
  </section>

  <section id="urgent" class="section3 py-2 my-5 ">
    <div class="container py-5 text-center">
      <h2>Urgent Fundraising Project</h2>
      <p>Kami berkomitmen untuk memberikan bantuan kepada mereka yang membutuhkan dengan harapan dapat meringankan beban mereka dalam menghadapi berbagai tantangan. Dalam upaya ini, kami dengan senang hati memperkenalkan proyek donasi terbaru yang kami luncurkan, yang berfokus pada membantu masyarakat yang membutuhkan.</p>
      <div class="row">
        <?php
        require_once "koneksi.php";

        // Mengambil data dari tabel open_donasi
        $today = date('Y-m-d');
        $nextWeek = date('Y-m-d', strtotime('+2 week'));
        $sql = "SELECT * FROM open_donasi WHERE target_hari BETWEEN '$today' AND '$nextWeek'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
          // Looping untuk setiap baris data
          while ($row = $result->fetch_assoc()) {
            $donasi_id = $row["donasi_id"];
            $thumbnail = $row["thumbnail"];
            $title = $row["title"];
            $target_donasi = $row["target_donasi"];
            $uang_donasi = $row["uang_donasi"];
            $target_hari = $row["target_hari"];
            $tgl_sekarang = date("Y-m-d");
            $sisa_hari = floor((strtotime($target_hari) - strtotime($tgl_sekarang)) / (60 * 60 * 24));
            $progress = ($uang_donasi / $target_donasi) * 100;



            // Tampilkan card untuk setiap data
            echo '<div class="col-4 px-2">';
            echo '<div class="card px-3">';
            echo '<form action="donationspage.php" method="post">';
            echo '<input name="donasi_id" type="text" hidden value="' . $donasi_id . '">';
            echo '<img src="./src/img_upload/thumbnail/' . $thumbnail . '" class="card-img-top mt-3 rounded" alt="Thumbnail">';
            echo '<div class="card-body">';
            echo '<h5 class="card-title">' . $title . '</h5>';
            echo '<div class="progress">';
            echo '<div class="progress-bar" role="progressbar" style="width: ' . $progress . '%;" aria-valuenow="' . $progress . '" aria-valuemin="0" aria-valuemax="100">' . $progress . '%</div>';
            echo '</div>';
            echo '<p class="card-text">Target Donasi: ' . $uang_donasi . '/' . $target_donasi . ' <br> Sisa Hari: ' . $sisa_hari . ' </p>';
            echo '<button type="submit" class="btn btn-primary">Donasi</button>';
            echo '</div>';
            echo '</form>';
            echo '</div>';
            echo '</div>';
          }
        } else {
          echo "<div class='my-5 mx-auto'><p>Tidak ada data yang ditemukan.</p></div>";
        }
        $conn->close();

        ?>

      </div>
    </div>
  </section>

  <div class="carousel slide" data-bs-ride="carousel" id="carouselExampleIndicators">
    <div class="carousel-indicators">
      <button aria-label="Slide 1" class="active" data-bs-slide-to="0" data-bs-target="#carouselExampleIndicators" type="button"></button> <button aria-label="Slide 2" data-bs-slide-to="1" data-bs-target="#carouselExampleIndicators" type="button"></button> <button aria-label="Slide 3" data-bs-slide-to="2" data-bs-target="#carouselExampleIndicators" type="button"></button>
    </div>
    <div class="carousel-inner">
      <div class="carousel-item active">
        <img class="d-block w-100" src="src/img_carousel/3(2).jpg">
        <div class="carousel-caption">
          <h5>Berbagi Ramadhan</h5>
          <p>Dalam bulan suci Ramadan ini, kami ingin mempersembahkan kesempatan bagi Anda untuk berbagi kebahagiaan dengan sesama. Melalui program ini, kami mengajak Anda untuk ikut berpartisipasi dalam menyediakan takjil dan hidangan berbuka puasa untuk mereka yang membutuhkan.</p>
        </div>
      </div>
      <div class="carousel-item">
        <img class="d-block w-100" src="src/img_carousel/3(3).jpg">
        <div class="carousel-caption">
          <h5>Berbagi Di Jalan</h5>
          <p>Berbagi di Jalan adalah platform penggalangan dana yang memberikan kesempatan kepada semua orang untuk turut serta dalam proyek-proyek sosial yang mendesak.</p>
        </div>
      </div>
      <div class="carousel-item">
        <img class="d-block w-100" src="src/img_carousel/3(4).jpg">
        <div class="carousel-caption">
          <h5>Berbagi Jumat Berkah</h5>
          <p>Selamat datang di Berbagi di Jumat Berkah! Kami adalah platform penggalangan dana yang bertujuan untuk membantu dan mendukung berbagai proyek sosial, amal, dan kemanusiaan yang dilakukan oleh masyarakat.</p>
        </div>
      </div>
    </div><button class="carousel-control-prev" data-bs-slide="prev" data-bs-target="#carouselExampleIndicators" type="button"><span aria-hidden="true" class="carousel-control-prev-icon"></span> <span class="visually-hidden">Previous</span></button> <button class="carousel-control-next" data-bs-slide="next" data-bs-target="#carouselExampleIndicators" type="button"><span aria-hidden="true" class="carousel-control-next-icon"></span> <span class="visually-hidden">Next</span></button>
  </div><!-- about section starts -->

  <!-- services section Starts -->
  <section class="services section-padding" id="project">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="section-header text-center pb-5">
            <h2>Project</h2>
            <p>Proyek ini memiliki tujuan utama untuk meringankan beban masyarakat yang kurang mampu atau terkena musibah. Dengan kerjasama dan dukungan dari para dermawan seperti Anda, kami yakin dapat mencapai perubahan yang positif dan memberikan dampak nyata bagi masyarakat.</p>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-12 col-md-6 col-lg-4 p-3">
          <form action="donationspage.php" method="post">
            <div class="card text-white text-center bg-dark pb-2">
              <div class="card-body">
                <input name="donasi_id" type="text" hidden value="8">
                <i class="bi bi-laptop"></i>
                <h4 class="card-title">Patungan Pohon Bantu Hijaukan Bumi</h4>
                <p class=""> Hai Orang Baik dan teman-teman Carat Indonesia! Apa kabar?
                  Aku doakan kalian senantiasa dalam keadaan sehat dan bahagia ya. aku Jenifer Wirawan.
                  Sangat senang berkesempatan mengajak kalian semua ikut project kebaikan ini.</p>
                <button type="submit" class="btn bg-warning text-dark">Read More</button>
              </div>
            </div>
          </form>
        </div>
        <div class="col-12 col-md-6 col-lg-4 p-3">
          <form action="donationspage.php" method="post">
            <div class="card text-white text-center bg-dark pb-2">
              <div class="card-body">
                <input name="donasi_id" type="text" hidden value="10">
                <i class="bi bi-journal"></i>
                <h4 class="card-title">Infaq Beras Untuk Fakir ,Miskin & Penghafal AlQuran</h4>
                <p class="">Perkenalkan, Program Infaq Beras Penghafal AlQuran ini merupakan Support Beras untuk Fakir, Miskin dan para Santri Penghafal AlQuran Ma’had ‘Aly Pondok Quran untuk kebutuhan pokok sehari - hari. </p>
                <button class="btn bg-warning text-dark">Read More</button>
              </div>
            </div>
        </div>
        </form>
        <div class="col-12 col-md-6 col-lg-4 p-3">
          <form action="donationspage.php" method="post">
            <div class="card text-white text-center bg-dark pb-2">
              <div class="card-body">
                <input name="donasi_id" type="text" hidden value="9">
                <i class="bi bi-intersect"></i>
                <h4 class="card-title">Infaq Yatim: Kebahagiaan untuk 500 anak-anak Yatim </h4>
                <p class="">Tak jarang juga anak-anak yatim dhuafa harus menanggung beban yang lebih berat lagi karena terpaksa tidak bisa menggapai keinginan dan cita-citanya dan harus bekerja demi bisa membantu memenuhi kebutuhan sehari-harinya.</p>
                <button class="btn bg-warning text-dark">Read More</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </section><!-- services section Ends -->



  <section class="about section-padding" id="about">
    <div class="container">
      <div class="row">
        <div class="col-lg-4 col-md-12 col-12">
          <div class="about-img"><img alt="" class="img-fluid" src="src/img_carousel/3(5).jpg"></div>
        </div>
        <div class="col-lg-8 col-md-12 col-12">
          <div class="about-text">
            <h2> Berbagi International </h2>
            <p>Berbagi International is a powerful global movement committed to nurturing compassion, empathy, and united efforts towards creating a brighter and more harmonious world.</p>
            <p>At Berbagi International, we believe in the transformative power of kindness and the profound impact it can have on individuals, communities, and societies at large. Our initiative serves as a catalyst for positive change, inspiring people from all walks of life to come together and make a meaningful difference.</p>
          </div>
        </div>
      </div>
    </div>
  </section><!-- about section Ends -->


  <!-- portfolio strats -->
  <section class="portfolio section-padding" id="benefit">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="section-header text-center pb-5">
            <h2>Benefits</h2>
            <p>Donasi memiliki banyak manfaat, baik bagi mereka yang menerima bantuan maupun bagi diri Anda sendiri. Dengan berdonasi, Anda dapat memberikan perubahan positif dalam hidup orang-orang dan berperan aktif dalam membangun masyarakat yang lebih baik.</p>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-12 col-md-4">
          <div class="card text-light cardhoverbenefit text-center bg-white pb-2">
            <div class="card-body text-dark">
              <div class="img-area mb-4">
                <img alt="" class="" style="height: 80px;" src="src/img_project/charity.png">
              </div>
              <h3 class="card-title">Bantuan kepada yang Membutuhkan</h3>
              <p class="card-text">Dengan berdonasi, Anda memiliki kesempatan untuk memberikan bantuan kepada mereka yang membutuhkan. Setiap sumbangan yang Anda berikan dapat memberikan harapan dan perubahan positif dalam kehidupan mereka. Bersama-sama, kita dapat mengatasi tantangan yang dihadapi oleh mereka yang kurang beruntung dan memberikan mereka kesempatan yang lebih baik untuk masa depan yang lebih cerah.</p>
            </div>
          </div>
        </div>
        <div class="col-12 col-md-4">
          <div class="card text-light cardhoverbenefit text-center bg-white pb-2">
            <div class="card-body text-dark">
              <div class="img-area mb-4">
                <img alt="" class="" style="height: 80px;" src="src/img_project/social-security.png">
              </div>
              <h3 class="card-title">Mengurangi Kesenjangan Sosial</h3>
              <p class="card-text">Donasi adalah langkah nyata dalam mengurangi kesenjangan sosial. Dengan memberikan sumbangan, Anda ikut berperan dalam membangun masyarakat yang lebih adil dan merata. Setiap kontribusi Anda membantu menciptakan akses dan peluang yang lebih baik bagi mereka yang kurang beruntung. Bersama-sama, kita dapat mencapai kesetaraan dan keadilan sosial.</p>
            </div>
          </div>
        </div>
        <div class="col-12 col-md-4">
          <div class="card text-light cardhoverbenefit text-center bg-white pb-2">
            <div class="card-body text-dark">
              <div class="img-area mb-4">
                <img alt="" class="" style="height: 80px;" src="src/img_project/certificate(1).png">
              </div>
              <h3 class="card-title">Sertifikat Penghargaan</h3>
              <p class="card-text">kesempatan untuk mendapatkan sertifikat penghargaan atas kontribusi Anda. Dengan melakukan donasi, Anda diakui atas upaya dan kebaikan yang telah Anda berikan. Sertifikat ini bukan hanya sebagai bentuk apresiasi, tetapi juga sebagai pengingat akan peran penting Anda dalam membantu mereka yang membutuhkan. Sertifikat ini dapat menjadi bukti nyata dari dampak positif yang telah Anda ciptakan dalam membantu menciptakan perubahan yang lebih baik.</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- portfolio ends -->


  <!-- Section: Cara Berdonasi -->
  <section class="portfolio section-padding" id="guide">
    <div class="container">
      <div class="row mt-4">
        <div class="col-md-12">
          <div class="section-header text-center pb-5">
            <h2>Cara Berdonasi</h2>
            <p>Ikuti langkah-langkah berikut untuk berdonasi di Takaful</p>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-12 col-md-4">
          <div class="card text-light text-center bg-white pb-2">
            <div class="card-body text-dark">
              <div class="img-area mb-4"><img alt="" class="img-fluid" src="src/img_project/guide (1).png"></div>
              <p>1. Dari halaman web, gulir ke bawah hingga menemukan proyek yang ingin didonasikan</p>
            </div>
          </div>
        </div>
        <div class="col-12 col-md-4">
          <div class="card text-light text-center bg-white pb-2">
            <div class="card-body text-dark">
              <div class="img-area mb-4"><img alt="" class="img-fluid" src="src/img_project/guide (2).png"></div>
              <p>2. Pilih salah satu proyek dan klik tombol "Donasi"</p>
            </div>
          </div>
        </div>
        <div class="col-12 col-md-4">
          <div class="card text-light text-center bg-white pb-2">
            <div class="card-body text-dark">
              <div class="img-area mb-4"><img alt="" class="img-fluid" src="src/img_project/guide (3).png"></div>
              <p>3. Akan disediakan informasi terkait proyek donasi yang dipilih</p>
            </div>
          </div>
        </div>
      </div>
      <div class="row mt-4">
        <div class="col-12 col-md-4">
          <div class="card text-light text-center bg-white pb-2">
            <div class="card-body text-dark">
              <div class="img-area mb-4"><img alt="" class="img-fluid" src="src/img_project/guide (4).png"></div>
              <p>4. Klik tombol "Donasi Sekarang"</p>
            </div>
          </div>
        </div>
        <div class="col-12 col-md-4">
          <div class="card text-light text-center bg-white pb-2">
            <div class="card-body text-dark">
              <div class="img-area mb-4"><img alt="" class="img-fluid" src="src/img_project/guide (5).png"></div>
              <p>5. Akan muncul sebuah formulir, lengkapi formulir tersebut dengan informasi yang diminta</p>
            </div>
          </div>
        </div>
        <div class="col-12 col-md-4">
          <div class="card text-light text-center bg-white pb-2">
            <div class="card-body text-dark">
              <div class="img-area mb-4"><img alt="" class="img-fluid" src="src/img_project/guide (6).png"></div>
              <p>6. Setelah melengkapi formulir, klik tombol "Submit"</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- Akhir Section: Cara Berdonasi -->





  <!-- team starts -->
  <section class="team section-padding" id="team">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="section-header text-center pb-5">
            <h2>Our Team</h2>
            <p>Kami adalah tim pengembang website ini yang terdiri dari dua orang yang berdedikasi untuk memberikan pengalaman terbaik kepada pengguna kami.</p>
          </div>
        </div>
      </div>
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-3">
            <div class="card text-center">
              <div class="card-body">
                <img alt="" class="img-fluid rounded-circle" style="width: 200px; height: 200px; object-fit: cover; object-position: center; border-radius: 50%;" src="src/img_project/ari.jpg">
                <h3 class="card-title py-2 name">Ari Mahendra</h3>
                <p class="socials"><i class="bi bi-twitter text-dark mx-1"></i> <i class="bi bi-facebook text-dark mx-1"></i> <i class="bi bi-linkedin text-dark mx-1"></i> <i class="bi bi-instagram text-dark mx-1"></i></p>
                <p class="card-text">Front-end Appreciate</p>
              </div>
            </div>
          </div>
          <div class="col-3">
            <div class="card text-center">
              <div class="card-body">
                <img alt="" class="img-fluid rounded-circle" style="width: 200px; height: 200px; object-fit: cover; object-position: center; border-radius: 50%;" src="src/img_project/denokfix.jpg">
                <h3 class="card-title py-2 name">Denny Ariyana</h3>
                <p class="socials"><i class="bi bi-twitter text-dark mx-1"></i> <i class="bi bi-facebook text-dark mx-1"></i> <i class="bi bi-linkedin text-dark mx-1"></i> <i class="bi bi-instagram text-dark mx-1"></i></p>
                <p class="card-text">UI/UX Designer</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section><!-- team ends -->


  <section class="py-5 my-5 ">
    <div class="container">
      <div class="testimonial row">
        <div class="testimonial-content col-7 mx-auto text-center">
          <img class="profile-img mb-3" data-bs-toggle="modal" data-bs-target="#changeProfileModal" style="width: 150px; height: 150px; object-fit: cover; object-position: center; border-radius: 100%;" alt="" src="src/img_project/Gambar WhatsApp 2023-06-12 pukul 16.20.02.jpg">
          <p>“Kami mengundang Anda untuk ikut serta dalam proyek ini dengan memberikan sumbangan atau donasi. Setiap bantuan yang diberikan akan digunakan secara efisien untuk memberikan bantuan yang tepat sasaran kepada mereka yang membutuhkan. Bersama-sama, kita dapat memberikan harapan dan kehidupan yang lebih baik bagi mereka yang sedang menghadapi kesulitan.”</p>
          <p>~Denny ariyana</p>
        </div>
      </div>
    </div>
  </section>
  <!-- Mulai Kontak -->
  <section class="contact section-padding" id="contact">
    <div class="container mt-5 mb-5">
      <div class="row">
        <div class="col-md-12">
          <div class="section-header text-center pb-5">
            <h2>Hubungi Kami</h2>
            <p>Terima kasih atas perhatian dan partisipasi Anda. Bersama-sama, mari kita berbuat baik dan memberikan dampak positif bagi kehidupan mereka yang membutuhkan.</p>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-6">
          <div class="contact-info">
            <h3>Informasi Kontak</h3>
            <p>Jika Anda memiliki pertanyaan atau ingin terlibat dalam inisiatif kami, jangan ragu untuk menghubungi kami. Kami senang mendengar dari Anda!</p>
            <ul>
              <li><i class="fa fa-map-marker my-1"></i>Surabaya, Jawa Timur, Indonesia</li>
              <li><i class="fa fa-envelope my-1"></i>TakafulIndonesia@gmail.com</li>
              <li><i class="fa fa-phone my-1"></i>+62 757 456 7890</li>
            </ul>
          </div>
        </div>
        <div class="col-md-6">
          <div class="contact-form">
            <h3>Kirim Pesan</h3>
            <form>
              <div class="form-group my-1">
                <input type="text" class="form-control" placeholder="Nama Anda" required>
              </div>
              <div class="form-group my-1">
                <input type="email" class="form-control" placeholder="Email Anda" required>
              </div>
              <div class="form-group my-1">
                <textarea class="form-control" rows="5" placeholder="Pesan Anda" required></textarea>
              </div>
              <button type="submit my-1" class="btn btn-primary">Kirim Pesan</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- Kontak selesai -->

  <!-- footer starts -->
  <footer class="bg-dark p-2 text-center">
    <div class="container">
      <p class="text-white">All Rights Reserved &copy; 2023 by TakafulIndonesia</p>
    </div>
  </footer>

  <!-- footer ends -->

  <!-- Add jQuery and Lottie Player JavaScript -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <script>
    $(document).ready(function() {
      AOS.init();
    });
  </script>
  <script>
    function previewFoto(event) {
      var input = event.target;
      var reader = new FileReader();
      reader.onload = function() {
        var preview = document.getElementById("preview");
        preview.src = reader.result;
      };
      reader.readAsDataURL(input.files[0]);
    }

    // Smooth scroll to anchor links
    document.querySelectorAll('nav a[href^="#"]').forEach(anchor => {
      anchor.addEventListener('click', function(e) {
        e.preventDefault();
        document.querySelector(this.getAttribute('href')).scrollIntoView({
          behavior: 'smooth'
        });
      });
    });
  </script>
  <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
  <script src="bootstrap/dist/js/bootstrap.min.js"></script>
  <script src="https://unpkg.com/@lottiefiles/lottie-player@1.5.7/dist/lottie-player.js"></script>
</body>

</html>