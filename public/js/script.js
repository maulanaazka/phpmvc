$(function () {
  $(".tombolTambahData").on("click", function () {
    // # => id component
    $("#judulModal").html("Tambah Data Mahasiswa");
    // . => class component
    $(".modal-footer button[type=submit]").html("Tambah Data");
    $("#nama").val("");
    $("#nim").val("");
    $("#email").val("");
    $("#jurusan").val("");
    $("#id").val("");
  });

  $(".tampilModalUbah").on("click", function () {
    $("#judulModal").html("Ubah Data Mahasiswa");
    $(".modal-footer button[type=submit]").html("Ubah Data");
    $(".modal-body form").attr("action", "http://localhost/phpmvc/public/mahasiswa/ubah");

    const id = $(this).data("id");

    // ajak untuk me-request data tanpa me-relog seluruh halaman (hanya komponen saja)
    $.ajax({
      url: "http://localhost/phpmvc/public/mahasiswa/getUbah",
      data: { id: id }, //data yang dikirim, isi datanya
      method: "POST",
      dataType: "json",
      success: function (data) {
        $("#nama").val(data.nama);
        $("#nim").val(data.nim);
        $("#email").val(data.email);
        $("#jurusan").val(data.jurusan);
        $("#id").val(data.id);
      },
    });
  });
});
