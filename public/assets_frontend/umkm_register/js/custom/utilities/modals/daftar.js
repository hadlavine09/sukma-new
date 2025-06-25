"use strict";
var form1 = [];
var form2 = [];
var form3 = [];
var KTCreateAccount = (function () {
    var e,
        t,
        i,
        o,
        r,
        s,
        n = [];
    return {
        init: function () {
            (e = document.querySelector("#kt_modal_create_account")) && new bootstrap.Modal(e),
                (t = document.querySelector("#kt_create_account_stepper")) &&
                    ((i = t.querySelector("#kt_create_account_form")),
                    (o = t.querySelector('[data-kt-stepper-action="submit"]')),
                    (r = t.querySelector('[data-kt-stepper-action="next"]')),
                    (s = new KTStepper(t)).on("kt.stepper.changed", function (e) {
                        4 === s.getCurrentStepIndex()
                            ? (o.classList.remove("d-none"), o.classList.add("d-inline-block"), r.classList.add("d-none"))
                            : 5 === s.getCurrentStepIndex()
                            ? (o.classList.add("d-none"), r.classList.add("d-none"))
                            : (o.classList.remove("d-inline-block"), o.classList.remove("d-none"), r.classList.remove("d-none"));
                    }),
                    s.on("kt.stepper.next", function (e) {
                        console.log("stepper.next2");
                        var idx = e.getCurrentStepIndex();
                        var t = n[e.getCurrentStepIndex() - 1];
                        // console.log("index", idx);
                        console.log(n);
                        if (idx === 1) {
                            // Validasi form 1 (UMKM)
                            form1 = [];
                            var nama_toko = document.getElementById("nama_toko").value.trim();
                            var no_hp = document.getElementById("no_hp").value.trim();
                            var kategori_toko = document.getElementById("kategori_toko").value.trim();
                            var alamat_toko = document.getElementById("alamat_toko").value.trim();
                            var logo_toko = document.getElementById("logo_toko").files.length > 0 ? document.getElementById("logo_toko").files[0] : null;
                            var deskripsi_toko = document.getElementById("deskripsi_toko").value.trim();

                            // Push ke array form1
                            form1.push(nama_toko, no_hp, kategori_toko, alamat_toko, logo_toko, deskripsi_toko);

                            // Validasi field kosong
                            if (
                                nama_toko === "" ||
                                no_hp === "" ||
                                kategori_toko === "" ||
                                alamat_toko === "" ||
                                !logo_toko ||
                                deskripsi_toko === ""
                            ) {
                                Swal.fire({
                                    text: "Semua field harus diisi sebelum melanjutkan",
                                    icon: "error",
                                    buttonsStyling: !1,
                                    confirmButtonText: "cek",
                                    customClass: {
                                        confirmButton: "btn btn-light",
                                    },
                                }).then(function () {
                                    KTUtil.scrollTop();
                                });
                                return false;
                            }

                            // Validasi nomor HP (hanya angka dan panjang 9-13)
                            var hpRegex = /^[0-9]{9,13}$/;
                            if (!hpRegex.test(no_hp)) {
                                Swal.fire({
                                    text: "No. HP harus berupa angka dan 9-13 digit",
                                    icon: "error",
                                    buttonsStyling: !1,
                                    confirmButtonText: "cek",
                                    customClass: {
                                        confirmButton: "btn btn-light",
                                    },
                                }).then(function () {
                                    KTUtil.scrollTop();
                                });
                                return false;
                            }

                            // Validasi logo file (opsional: hanya gambar)
                            if (logo_toko && !logo_toko.type.startsWith("image/")) {
                                Swal.fire({
                                    text: "Logo toko harus berupa file gambar",
                                    icon: "error",
                                    buttonsStyling: !1,
                                    confirmButtonText: "cek",
                                    customClass: {
                                        confirmButton: "btn btn-light",
                                    },
                                }).then(function () {
                                    KTUtil.scrollTop();
                                });
                                return false;
                            }

                            console.log("validasi form 1");
                            console.log(form1);
                        } else if (idx === 2) {
                            // Validasi form 2 (Dokumen Kepemilikan)
                            form2 = [];
                            var nama_ktp = document.getElementById("nama_ktp").value.trim();
                            var nomor_ktp = document.getElementById("nomor_ktp").value.trim();
                            var nomor_kk = document.getElementById("nomor_kk").value.trim();
                            var foto_ktp = document.getElementById("foto_ktp").files.length > 0 ? document.getElementById("foto_ktp").files[0] : null;
                            var foto_kk = document.getElementById("foto_kk").files.length > 0 ? document.getElementById("foto_kk").files[0] : null;

                            // Push ke array form2
                            form2.push(nama_ktp, nomor_ktp, nomor_kk, foto_ktp, foto_kk);

                            // Validasi field kosong
                            if (
                                nama_ktp === "" ||
                                nomor_ktp === "" ||
                                nomor_kk === "" ||
                                !foto_ktp ||
                                !foto_kk
                            ) {
                                Swal.fire({
                                    text: "Semua field dokumen harus diisi sebelum melanjutkan",
                                    icon: "error",
                                    buttonsStyling: !1,
                                    confirmButtonText: "cek",
                                    customClass: {
                                        confirmButton: "btn btn-light",
                                    },
                                }).then(function () {
                                    KTUtil.scrollTop();
                                });
                                return false;
                            }

                            // Validasi nomor KTP & KK (hanya angka dan 16 digit)
                            var nomorRegex = /^[0-9]{16}$/;
                            if (!nomorRegex.test(nomor_ktp)) {
                                Swal.fire({
                                    text: "Nomor KTP harus 16 digit angka",
                                    icon: "error",
                                    buttonsStyling: !1,
                                    confirmButtonText: "cek",
                                    customClass: {
                                        confirmButton: "btn btn-light",
                                    },
                                }).then(function () {
                                    KTUtil.scrollTop();
                                });
                                return false;
                            }
                            if (!nomorRegex.test(nomor_kk)) {
                                Swal.fire({
                                    text: "Nomor KK harus 16 digit angka",
                                    icon: "error",
                                    buttonsStyling: !1,
                                    confirmButtonText: "cek",
                                    customClass: {
                                        confirmButton: "btn btn-light",
                                    },
                                }).then(function () {
                                    KTUtil.scrollTop();
                                });
                                return false;
                            }

                            // Validasi file gambar
                            if (foto_ktp && !foto_ktp.type.startsWith("image/")) {
                                Swal.fire({
                                    text: "Foto KTP harus berupa file gambar",
                                    icon: "error",
                                    buttonsStyling: !1,
                                    confirmButtonText: "cek",
                                    customClass: {
                                        confirmButton: "btn btn-light",
                                    },
                                }).then(function () {
                                    KTUtil.scrollTop();
                                });
                                return false;
                            }
                            if (foto_kk && !foto_kk.type.startsWith("image/")) {
                                Swal.fire({
                                    text: "Foto KK harus berupa file gambar",
                                    icon: "error",
                                    buttonsStyling: !1,
                                    confirmButtonText: "cek",
                                    customClass: {
                                        confirmButton: "btn btn-light",
                                    },
                                }).then(function () {
                                    KTUtil.scrollTop();
                                });
                                return false;
                            }

                            console.log("validasi form 2");
                            console.log(form2);
                        } else if (idx === 3) {
                            // validasi form 3
                            form3 = [];
                            form3.push($("#tujuan").val(), $("#tanggal").val(), $("#waktu").val(), $("#layanan").val());
                            var tujuan = document.getElementById("tujuan").value;
                            var tanggal = document.getElementById("tanggal").value;
                            var waktu = document.getElementById("waktu").value;
                            var layanan = document.getElementById("layanan").value;
                            if (layanan == "" && tujuan == "" && tanggal == "" && waktu == "") {
                                Swal.fire({
                                    text: "Isi Terlebih Dahulu Sebelum Melanjutkan",
                                    icon: "error",
                                    buttonsStyling: !1,
                                    confirmButtonText: "cek",
                                    customClass: {
                                        confirmButton: "btn btn-light",
                                    },
                                }).then(function () {
                                    KTUtil.scrollTop();
                                });
                                return false;
                            } else if (tanggal == "") {
                                Swal.fire({
                                    text: "Pastikan Form Tanggal Terisi ",
                                    icon: "error",
                                    buttonsStyling: !1,
                                    confirmButtonText: "cek",
                                    customClass: {
                                        confirmButton: "btn btn-light",
                                    },
                                }).then(function () {
                                    KTUtil.scrollTop();
                                });
                                return false;
                            } else if (waktu == "") {
                                Swal.fire({
                                    text: "Pastikan Form Waktu Kunjungan Anda Terisi ",
                                    icon: "error",
                                    buttonsStyling: !1,
                                    confirmButtonText: "cek",
                                    customClass: {
                                        confirmButton: "btn btn-light",
                                    },
                                }).then(function () {
                                    KTUtil.scrollTop();
                                });
                                return false;
                            } else if (layanan == "") {
                                Swal.fire({
                                    text: "Pastikan Form Layanan Anda Terisi ",
                                    icon: "error",
                                    buttonsStyling: !1,
                                    confirmButtonText: "cek",
                                    customClass: {
                                        confirmButton: "btn btn-light",
                                    },
                                }).then(function () {
                                    KTUtil.scrollTop();
                                });
                                return false;
                            } else if (tujuan == "") {
                                Swal.fire({
                                    text: "Pastikan Form Kantor Tujuan Anda Terisi ",
                                    icon: "error",
                                    buttonsStyling: !1,
                                    confirmButtonText: "cek",
                                    customClass: {
                                        confirmButton: "btn btn-light",
                                    },
                                }).then(function () {
                                    KTUtil.scrollTop();
                                });
                                return false;
                            }
                            $(document).ready(function () {
                                // Department Change
                                $("#tujuan").change(function () {
                                    // Department id
                                    var id = $(this).val();

                                    // Empty the dropdown
                                    $("#sel_emp").find("option").not(":first").remove();

                                    // AJAX request
                                    $.ajax({
                                        url: "getEmployees/" + id,
                                        type: "get",
                                        dataType: "json",
                                        success: function (response) {
                                            var len = 0;
                                            if (response["data"] != null) {
                                                len = response["data"].length;
                                            }

                                            if (len > 0) {
                                                // Read data and create <option >
                                                for (var i = 0; i < len; i++) {
                                                    var id = response["data"][i].id;
                                                    var name = response["data"][i].name;

                                                    var option = "<option value='" + id + "'>" + name + "</option>";

                                                    $("#sel_emp").append(option);
                                                }
                                            }
                                        },
                                    });
                                });
                            });

                            if (tujuan == "Bappenda Kabupaten Bogor") {
                                $("#conf-alamat-kantor").val("Jl. Tegar Beriman No.1, Pakansari, Kec. Cibinong, Kabupaten Bogor, Jawa Barat 16914");
                            } else if (tujuan == "Bappenda Kabupaten Bandung") {
                                $("#conf-alamat-kantor").val("Jl. Raya Soreang No.Km. 17, Pamekaran, Kec. Soreang, Kabupaten Bandung, Jawa Barat 40912");
                            } else if (tujuan == "Bappenda Kota Bandung") {
                                $("#conf-alamat-kantor").val("Jl. Sukabumi, Kacapiring, Kec. Batununggal, Kota Bandung, Jawa Barat 40271");
                            } else if (tujuan == "Bappenda Kota Bogor") {
                                $("#conf-alamat-kantor").val("Jl. Pemuda No.31, RT.01/RW.06, Tanah Sareal, Kec. Tanah Sereal, Kota Bogor, Jawa Barat 16162");
                            } else if (tujuan == "Bappenda Kabupaten Bandung Barat") {
                                $("#conf-alamat-kantor").val("Mekarsari, Kec. Ngamprah, Kabupaten Bandung Barat, Jawa Barat 40552");
                            } else if (tujuan == "Bappenda Kota Bekasi") {
                                $("#conf-alamat-kantor").val("Jl. Ir. H. Juanda No.100, RT.001/RW.005, Margahayu, Kec. Bekasi Tim., Kota Bks, Jawa Barat 17113");
                            } else if (tujuan == "Bappenda Kabupaten Bekasi") {
                                $("#conf-alamat-kantor").val("Sukamahi, Kec. Cikarang Pusat, Kabupaten Bekasi, Jawa Barat 17530");
                            } else if (tujuan == "Bappenda Kabupaten Ciamis") {
                                $("#conf-alamat-kantor").val("Jl. Stasiun No.18, Ciamis, Kec. Ciamis, Kabupaten Ciamis, Jawa Barat 46211");
                            } else if (tujuan == "Bappenda Kabupaten Cianjur") {
                                $("#conf-alamat-kantor").val("Jl. Raya Bandung No.65, Bojong, Kec. Karangtengah, Kabupaten Cianjur, Jawa Barat 43281");
                            } else if (tujuan == "Bappenda Kota Cirebon") {
                                $("#conf-alamat-kantor").val("Jl. Monumen No.1, Sunyaragi, Kec. Kesambi, Kota Cirebon, Jawa Barat 45132");
                            } else if (tujuan == "Bappenda Kabupaten Cirebon") {
                                $("#conf-alamat-kantor").val("Jl. Sunan Ampel No.1, Sumber, Kec. Sumber, Kabupaten Cirebon, Jawa Barat 45611");
                            } else if (tujuan == "Bappenda Kabupaten Garut") {
                                $("#conf-alamat-kantor").val("Sukagalih, Kec. Tarogong Kidul, Kabupaten Garut, Jawa Barat 44151");
                            } else if (tujuan == "Bappenda Kabupaten Indramayu") {
                                $("#conf-alamat-kantor").val("Jl. Gatot Subroto, Kepandean, Kec. Indramayu, Kabupaten Indramayu, Jawa Barat 45214");
                            } else if (tujuan == "Bappenda Kabupaten Karawang") {
                                $("#conf-alamat-kantor").val("Jl. Siliwangi No.2, Nagasari, Kec. Karawang Barat, Karawang, Jawa Barat 41312");
                            } else if (tujuan == "Bappenda Kabupaten Kuningan") {
                                $("#conf-alamat-kantor").val("Kuningan, Kec. Kuningan, Kabupaten Kuningan, Jawa Barat 45511");
                            } else if (tujuan == "Bappenda Kabupaten Majalengka") {
                                $("#conf-alamat-kantor").val("Jl. Kyai H. Abdul Halim, Cigasong, Kec. Cigasong, Kabupaten Majalengka, Jawa Barat 45476");
                            } else if (tujuan == "Bappenda Kabupaten Pangandaran") {
                                $("#conf-alamat-kantor").val("Jl.Jl. Raya Cijulang No.159, Parigi, Parigi, Kec. Parigi, Kabupaten  Pangandaran, Jawa Barat 46393");
                            } else if (tujuan == "Bappenda Kabupaten Purwakarta") {
                                $("#conf-alamat-kantor").val("Jl. Surawinata No.30A, Nagri Tengah, Kec. Purwakarta, Kabupaten Purwakarta, Jawa Barat 41114");
                            } else if (tujuan == "Bappenda Kabupaten Subang") {
                                $("#conf-alamat-kantor").val("Jl. Letnan Jenderal S. Parman No.3, Soklat, Kec. Subang, Kabupaten Subang, Jawa Barat 41211");
                            } else if (tujuan == "Bappenda Kota Sukabumi") {
                                $("#conf-alamat-kantor").val("Jl. Sarasa No.9, Babakan, Kec. Cibeureum, Kota Sukabumi, Jawa Barat 43142");
                            } else if (tujuan == "Bappenda Kabupaten Sukabumi") {
                                $("#conf-alamat-kantor").val("Citepus, Kec. Pelabuhanratu, Kabupaten Sukabumi, Jawa Barat 43364");
                            } else if (tujuan == "Bappenda Kabupaten Sumedang") {
                                $("#conf-alamat-kantor").val("Sumedang, Situ, Kec. Sumedang Utara, Kabupaten Sumedang, Jawa Barat 45621");
                            } else if (tujuan == "Bappenda Kota Tasikmalaya") {
                                $("#conf-alamat-kantor").val("Jl. Siliwangi No.31, Kahuripan, Kec. Tawang, Kabupaten  Tasikmalaya, Jawa Barat 46115");
                            } else if (tujuan == "Bappenda Kabupaten Tasikmalaya") {
                                $("#conf-alamat-kantor").val("Jl. Raya Pemda, Singasari, Kec. Singaparna, Kabupaten Tasikmalaya, Jawa Barat 46415");
                            } else if (tujuan == "Bappenda Kota Cimahi") {
                                $("#conf-alamat-kantor").val("Jl. Raden Demang Harja Kusumah No.1, Cibabat, Cimahi Utara, Kota Cimahi , Jawa Barat 40132");
                            } else if (tujuan == "Bappenda Kota Banjar") {
                                $("#conf-alamat-kantor").val("Jl. Brigjenm. Isa, SH, Purwaharja, Kec. Purwaharja, Kota Banjar, Jawa Barat 46331");
                            }
                            console.log("validasi form 3");
                            console.log(form3);

                            //  var n = new Date();
                            //  document.getElementById("no_tiket").value = "-"+ (("0"+dt.getDate()).slice(-2)) + (("0"+(dt.getMonth()+1)).slice(-2)) + (dt.getFullYear()) +"-"+ (("0"+dt.getHours()).slice(-2)) + (("0"+dt.getMinutes()).slice(-2));

                            // $("no_tiket").val((("0"+dt.getDate()).slice(-2)) + (("0"+(dt.getMonth()+1)).slice(-2)) + (dt.getFullYear()) +"-"+ (("0"+dt.getHours()).slice(-2)) + (("0"+dt.getMinutes()).slice(-2)));
                            $("#conf-kantor-tujuan").val(form3[0]);
                            $("#conf-layanan").val(form3[3]);
                            $("#conf-tanggal-kunjungan").val(form3[1]);
                            $("#conf-sesi-pelayanan").val(form3[2]);
                            $("#tujuan_akhir").val(form3[0]);
                            $("#tanggal_akhir").val(form3[1]);
                            $("#waktu_akhir").val(form3[2]);
                            $("#layanan_akhir").val(form3[3]);
                            $("#nik_akhir").val(form1[0]);
                            $("#nama_tiket").val(form1[1]);
                            $("#kantor").val(form3[0]);
                            // $("#kantor").val(form3[0])
                        }

                        t
                            ? t.validate().then(function (t) {
                                  console.log("validated!"),
                                      "Valid" == t
                                          ? (e.goNext(), KTUtil.scrollTop())
                                          : Swal.fire({
                                                text: "Jangan ada data yang terlewat, mohon periksa kembali",
                                                icon: "error",
                                                buttonsStyling: !1,
                                                confirmButtonText: "cek",
                                                customClass: {
                                                    confirmButton: "btn btn-light",
                                                },
                                            }).then(function () {
                                                KTUtil.scrollTop();
                                            });
                              })
                            : (e.goNext(), KTUtil.scrollTop());
                    }),
                    s.on("kt.stepper.previous", function (e) {
                        console.log("stepper.previous"), e.goPrevious(), KTUtil.scrollTop();
                    }),
                    n.push(
                        FormValidation.formValidation(i, {
                            fields: {
                                nik: {
                                    validators: {
                                        notEmpty: {
                                            message: "Isi data NIK anda",
                                        },
                                    },
                                },
                                nama: {
                                    validators: {
                                        notEmpty: {
                                            message: "Isi data NAMA anda",
                                        },
                                    },
                                },
                                email: {
                                    validators: {
                                        notEmpty: {
                                            message: "Isi data EMAIL anda",
                                        },
                                    },
                                },
                                no_hp: {
                                    validators: {
                                        notEmpty: {
                                            message: "Isi data KONTAK anda",
                                        },
                                    },
                                },
                                tanya: {
                                    validators: {
                                        notEmpty: {
                                            message: "pilih salah satu",
                                        },
                                    },
                                },
                            },
                            plugins: {
                                trigger: new FormValidation.plugins.Trigger(),
                                bootstrap: new FormValidation.plugins.Bootstrap5({
                                    rowSelector: ".fv-row",
                                    eleInvalidClass: "",
                                    eleValidClass: "",
                                }),
                            },
                        })
                    ),
                    n.push(
                        FormValidation.formValidation(i, {
                            fields: {
                                tanya: {
                                    validators: {
                                        notEmpty: {
                                            message: "Time size is required",
                                        },
                                    },
                                },
                            },
                            plugins: {
                                trigger: new FormValidation.plugins.Trigger(),
                                bootstrap: new FormValidation.plugins.Bootstrap5({
                                    rowSelector: ".fv-row",
                                    eleInvalidClass: "",
                                    eleValidClass: "",
                                }),
                            },
                        })
                    ),
                    n.push(
                        FormValidation.formValidation(i, {
                            fields: {
                                business_name: {
                                    validators: {
                                        notEmpty: {
                                            message: "Busines name is required",
                                        },
                                    },
                                },
                                business_descriptor: {
                                    validators: {
                                        notEmpty: {
                                            message: "Busines descriptor is required",
                                        },
                                    },
                                },
                                business_type: {
                                    validators: {
                                        notEmpty: {
                                            message: "Busines type is required",
                                        },
                                    },
                                },
                                business_description: {
                                    validators: {
                                        notEmpty: {
                                            message: "Busines description is required",
                                        },
                                    },
                                },
                                business_email: {
                                    validators: {
                                        notEmpty: {
                                            message: "Busines email is required",
                                        },
                                        emailAddress: {
                                            message: "The value is not a valid email address",
                                        },
                                    },
                                },
                            },
                            plugins: {
                                trigger: new FormValidation.plugins.Trigger(),
                                bootstrap: new FormValidation.plugins.Bootstrap5({
                                    rowSelector: ".fv-row",
                                    eleInvalidClass: "",
                                    eleValidClass: "",
                                }),
                            },
                        })
                    ),
                    n.push(
                        FormValidation.formValidation(i, {
                            fields: {
                                card_name: {
                                    validators: {
                                        notEmpty: {
                                            message: "Name on card is required",
                                        },
                                    },
                                },
                                card_number: {
                                    validators: {
                                        notEmpty: {
                                            message: "Card member is required",
                                        },
                                        creditCard: {
                                            message: "Card number is not valid",
                                        },
                                    },
                                },
                                card_expiry_month: {
                                    validators: {
                                        notEmpty: {
                                            message: "Month is required",
                                        },
                                    },
                                },
                                card_expiry_year: {
                                    validators: {
                                        notEmpty: {
                                            message: "Year is required",
                                        },
                                    },
                                },
                                card_cvv: {
                                    validators: {
                                        notEmpty: {
                                            message: "CVV is required",
                                        },
                                        digits: {
                                            message: "CVV must contain only digits",
                                        },
                                        stringLength: {
                                            min: 3,
                                            max: 4,
                                            message: "CVV must contain 3 to 4 digits only",
                                        },
                                    },
                                },
                            },
                            plugins: {
                                trigger: new FormValidation.plugins.Trigger(),
                                bootstrap: new FormValidation.plugins.Bootstrap5({
                                    rowSelector: ".fv-row",
                                    eleInvalidClass: "",
                                    eleValidClass: "",
                                }),
                            },
                        })
                    ),
                    o.addEventListener("click", function (e) {
                        n[3].validate().then(function (t) {
                            var nik = $("#nik").val();
                            var name = $("#nama").val();
                            var status = $("#status").val();
                            var email = $("#email").val();
                            var no_hp = $("#no_hp").val();
                            var tujuan = $("#tujuan").val();
                            var tanggal = $("#tanggal").val();
                            var layanan = $("#layanan").val();
                            var waktu = $("#waktu").val();
                            // var waktu = $("#no_tiket").val();
                            // var waktu = $("#no_antrian").val();
                            if (nik != "" && name != "" && email != "" && no_hp != "" && tujuan != "" && tanggal != "" && layanan != "" && waktu != "") {
                                /*  $ja("#butsave").attr("disabled", "disabled"); */
                                $.ajax({
                                    url: "/visitorCreate",
                                    type: "POST",
                                    data: {
                                        _token: $("#csrf").val(),
                                        type: 1,
                                        nik: nik,
                                        nama: name,
                                        status: status,
                                        email: email,
                                        no_hp: no_hp,
                                        tujuan: tujuan,
                                        tanggal: tanggal,
                                        layanan: layanan,
                                        waktu: waktu,
                                        // no_tiket: no_tiket,
                                        // no_antrian: no_antrian,
                                    },
                                    cache: false,
                                    success: function (dataResult) {
                                        console.log(dataResult);
                                        var dataResult = JSON.parse(dataResult);
                                        if (dataResult.statusCode == 200) {
                                    n =  new Date();
                                    $("#no_antrian").val(dataResult.data.no_antrian);
                                    $("#no_tiket").val(dataResult.data.no_tiket + "-" + (("0"+n.getDate()).slice(-2)) + (("0"+(n.getMonth()+1)).slice(-2)) + (n.getFullYear()) +"-"+ (("0"+n.getHours()).slice(-2)) + (("0"+n.getMinutes()).slice(-2)));

                                            console.log("validated!"),
                                                "Valid" == t
                                                    ? (e.preventDefault(),
                                                      (o.disabled = !0),
                                                      o.setAttribute("data-kt-indicator", "on"),
                                                      setTimeout(function () {
                                                          o.removeAttribute("data-kt-indicator"),
                                                              (o.disabled = !1),
                                                              i.hasAttribute("data-kt-redirect-url")
                                                                  ? Swal.fire({
                                                                        text: "Your account has been successfully created.",
                                                                        icon: "success",
                                                                        buttonsStyling: !1,
                                                                        confirmButtonText: "Ok, got it!",
                                                                        customClass: {
                                                                            confirmButton: "btn btn-primary",
                                                                        },
                                                                    }).then(function (e) {
                                                                        e.isConfirmed && (location.href = i.getAttribute("data-kt-redirect-url"));
                                                                    })
                                                                  : s.goNext();
                                                      }, 2e3))
                                                    : Swal.fire({
                                                          text: "Sorry, looks like there are some errors detected, please try again.",
                                                          icon: "error",
                                                          buttonsStyling: !1,
                                                          confirmButtonText: "Ok, got it!",
                                                          customClass: {
                                                              confirmButton: "btn btn-light",
                                                          },
                                                      }).then(function () {
                                                          KTUtil.scrollTop();
                                                      });
                                        } else if (dataResult.statusCode == 201) {
                                            alert("Error occured !");
                                        }
                                    },
                                    error: function (e) {
                                        Swal.fire({
                                            text: e,
                                            icon: "error",
                                            buttonsStyling: !1,
                                            confirmButtonText: "Ok, got it!",
                                            customClass: {
                                                confirmButton: "btn btn-light",
                                            },
                                        }).then(function () {
                                            KTUtil.scrollTop();
                                        });
                                    },
                                });
                            } else {
                                alert("Please fill all the field !");
                            }
                        });
                    }),
                    $(i.querySelector('[name="card_expiry_month"]')).on("change", function () {
                        n[3].revalidateField("card_expiry_month");
                    }),
                    $(i.querySelector('[name="card_expiry_year"]')).on("change", function () {
                        n[3].revalidateField("card_expiry_year");
                    }),
                    $(i.querySelector('[name="business_type"]')).on("change", function () {
                        n[2].revalidateField("business_type");
                    }));
        },
    };
})();
KTUtil.onDOMContentLoaded(function () {
    KTCreateAccount.init();
});

// function validateForm() {
//   let x = document.forms["myForm"]["fname"].value;
//   if (x == "") {
//     alert("Name must be filled out");
//     return false;
//   }
// }

//  n.push(
//             FormValidation.formValidation(i, {
//               fields: {
//                 nik: { validators: { notEmpty: { message: "Isi data NIK anda" } } },
//                 nama: { validators: { notEmpty: { message: "Isi data NAMA anda" } } },
//                 email: { validators: { notEmpty: { message: "Isi data EMAIL anda" } } },
//                 no_hp: { validators: { notEmpty: { message: "Isi data KONTAK anda" } } },
//               },
//               plugins: { trigger: new FormValidation.plugins.Trigger(), bootstrap: new FormValidation.plugins.Bootstrap5({ rowSelector: ".fv-row", eleInvalidClass: "", eleValidClass: "" }) },
//             })
//           ),
