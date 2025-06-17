document.addEventListener("DOMContentLoaded", function () {
    let cart = [];

    // Set today's date
    function setCurrentDate() {
        const today = new Date();
        const day = String(today.getDate()).padStart(2, "0");
        const month = String(today.getMonth() + 1).padStart(2, "0");
        const year = today.getFullYear();
        document.getElementById(
            "tgl_transaksi"
        ).value = `${year}-${month}-${day}`;
    }

    // Format currency
    function formatCurrency(number) {
        return new Intl.NumberFormat("id-ID", {
            style: "currency",
            currency: "IDR",
            minimumFractionDigits: 0,
        }).format(number);
    }

    // Get max stock from API
    async function getMaxStock(idBarang) {
        try {
            const response = await fetch(
                `/get-stock-barang?id_barang=${idBarang}`
            );
            if (!response.ok) {
                throw new Error("Gagal mengambil data stok");
            }
            const data = await response.json();
            return data.stock || 1; // Return 1 sebagai fallback
        } catch (error) {
            console.error("Error:", error);
            alert("Gagal memeriksa stok barang. Silakan coba lagi.");
            return 1; // Return nilai default jika terjadi error
        }
    }

    // Handle quantity change in cart
    async function handleQuantityChange(e) {
        const index = parseInt(e.target.dataset.index);
        let newQuantity = parseInt(e.target.value);

        // Validasi input
        if (isNaN(newQuantity)) {
            newQuantity = 1;
        } else if (newQuantity < 1) {
            newQuantity = 1;
        }

        // Dapatkan stok maksimum dari API
        const idBarang = cart[index].idBarang;
        const maxStock = await getMaxStock(idBarang);

        // Validasi stok
        if (newQuantity > maxStock) {
            newQuantity = maxStock;
            alert(
                `Stok tersedia: ${maxStock}. Jumlah diubah menjadi maksimum.`
            );
        }

        // Update nilai input
        e.target.value = newQuantity;

        // Update cart
        cart[index].jumlahBarang = newQuantity;
        cart[index].subtotal = newQuantity * cart[index].hargaSatuan;

        updateTotalTransaksi();
    }

    // Update cart table
    function updateCartTable() {
        const cartTableBody = document.querySelector("#cart-table tbody");
        const emptyCartRow = document.querySelector(".empty-cart");
        const cartSummary = document.getElementById("cart-summary");

        if (cart.length === 0) {
            cartTableBody.innerHTML = `
                <tr class="empty-cart">
                    <td colspan="6" class="text-center py-5">
                        <i class="fas fa-shopping-cart fa-3x mb-3"></i>
                        <div>Keranjang masih kosong</div>
                        <small>Tambahkan barang untuk memulai transaksi</small>
                    </td>
                </tr>
            `;
            cartSummary.style.display = "none";
            return;
        }

        cartTableBody.innerHTML = "";
        cart.forEach((item, index) => {
            const row = document.createElement("tr");
            // In the updateCartTable() function, modify the row.innerHTML to include name attribute
            row.innerHTML = `
    <td>${item.idBarang}</td>
    <td>${item.namaBarang}</td>
    <td>
        <input type="number" 
               class="form-control cart-quantity" 
               value="${item.jumlahBarang}" 
               min="1" 
               data-index="${index}"
               name="detil_penjualan[${index}][jml_barang]">
    </td>
    <td>${formatCurrency(item.hargaSatuan)}</td>
    <td>${formatCurrency(item.subtotal)}</td>
    <td>
        <button class="btn btn-danger btn-sm" onclick="removeFromCart(${index})">
            <i class="fas fa-trash"></i>
        </button>
    </td>
`;
            cartTableBody.appendChild(row);
        });

        // Add event listeners for quantity changes
        document.querySelectorAll(".cart-quantity").forEach((input) => {
            input.addEventListener("change", handleQuantityChange);
            input.addEventListener("blur", function (e) {
                if (!e.target.value || parseInt(e.target.value) < 1) {
                    e.target.value = 1;
                    handleQuantityChange(e);
                }
            });
        });

        cartSummary.style.display = "block";
        updateTotalTransaksi();
    }

    // Update total transaction
    function updateTotalTransaksi() {
        const total = cart.reduce((sum, item) => sum + item.subtotal, 0);
        document.getElementById("total_transaksi").value = total;
        document.getElementById("display-total").textContent =
            formatCurrency(total);
    }

    // Remove item from cart
    window.removeFromCart = function (index) {
        if (
            confirm(
                "Apakah Anda yakin ingin menghapus barang ini dari keranjang?"
            )
        ) {
            cart.splice(index, 1);
            updateCartTable();
        }
    };

    // Reset item form
    function resetItemForm() {
        const formRow = document.querySelector(".item-picker .row");
        formRow.querySelector(".id-barang").value = "";
        formRow.querySelector(".nama-barang").value = "";
        formRow.querySelector(".harga-barang").value = "";
        formRow.querySelector(".stock").value = "";
        formRow.querySelector(".jumlah-barang").value = "";
    }

    // Initialize
    setCurrentDate();

    // Customer selection
    document
        .getElementById("id_pelanggan")
        .addEventListener("change", function () {
            const idPelanggan = this.value;
            const namaField = document.getElementById("nama");
            const genderField = document.getElementById("gender");

            if (idPelanggan) {
                fetch(`/get-pelanggan?id_pelanggan=${idPelanggan}`)
                    .then((response) => {
                        if (!response.ok) {
                            throw new Error("Network response was not ok");
                        }
                        return response.json();
                    })
                    .then((data) => {
                        namaField.value = data.nama || "";
                        genderField.value = data.gender || "";
                    })
                    .catch((err) => {
                        console.error("Error:", err);
                        namaField.value = "";
                        genderField.value = "";
                    });
            } else {
                namaField.value = "";
                genderField.value = "";
            }
        });

    // Item selection
    document.addEventListener("change", function (e) {
        if (e.target.classList.contains("id-barang")) {
            const idBarang = e.target.value;
            if (idBarang) {
                fetch(`/get-barang?id_barang=${idBarang}`)
                    .then((response) => response.json())
                    .then((data) => {
                        const formRow = e.target.closest(".row");
                        formRow.querySelector(".nama-barang").value =
                            data.nama_barang || "";
                        formRow.querySelector(".harga-barang").value =
                            formatCurrency(data.harga_barang) || "";
                        formRow.querySelector(".stock").value =
                            data.stock || "";
                        formRow.querySelector(".harga-satuan").value =
                            data.harga_barang || "";

                        // Auto set quantity to 1 if empty
                        if (!formRow.querySelector(".jumlah-barang").value) {
                            formRow.querySelector(".jumlah-barang").value = 1;
                        }
                    })
                    .catch((err) => console.error("Error:", err));
            }
        }
    });

    // Add to cart
    document
        .getElementById("add-to-cart")
        .addEventListener("click", function () {
            const formRow = document.querySelector(".item-picker .row");
            const idBarang = formRow.querySelector(".id-barang").value;
            const namaBarang = formRow.querySelector(".nama-barang").value;
            const jumlahBarang =
                parseInt(formRow.querySelector(".jumlah-barang").value) || 0;
            const hargaSatuan =
                parseInt(formRow.querySelector(".harga-satuan").value) || 0;
            const stock = parseInt(formRow.querySelector(".stock").value) || 0;

            if (!idBarang || !jumlahBarang || !hargaSatuan) {
                alert("Silakan lengkapi data barang");
                return;
            }

            if (jumlahBarang > stock) {
                alert("Jumlah melebihi stok yang tersedia");
                return;
            }

            // Cek apakah barang sudah ada di keranjang
            const existingItemIndex = cart.findIndex(
                (item) => item.idBarang === idBarang
            );

            if (existingItemIndex !== -1) {
                // Jika barang sudah ada, tambahkan jumlahnya
                const newQuantity =
                    cart[existingItemIndex].jumlahBarang + jumlahBarang;

                // Pastikan tidak melebihi stok
                if (newQuantity > stock) {
                    alert(
                        "Total jumlah melebihi stok yang tersedia untuk barang ini"
                    );
                    return;
                }

                // Update jumlah dan subtotal
                cart[existingItemIndex].jumlahBarang = newQuantity;
                cart[existingItemIndex].subtotal = newQuantity * hargaSatuan;
            } else {
                // Jika barang belum ada, tambahkan baru
                const subtotal = jumlahBarang * hargaSatuan;
                cart.push({
                    idBarang,
                    namaBarang,
                    jumlahBarang,
                    hargaSatuan,
                    subtotal,
                });
            }

            updateCartTable();
            resetItemForm();
        });

    // Preview Invoice Button
    // Preview Invoice Button
    document
        .getElementById("preview-button")
        ?.addEventListener("click", async function (e) {
            e.preventDefault();

            if (cart.length === 0) {
                alert(
                    "Keranjang kosong. Silakan tambahkan barang terlebih dahulu."
                );
                return;
            }

            const idPelanggan = document.getElementById("id_pelanggan").value;
            if (!idPelanggan) {
                alert("Silakan pilih pelanggan terlebih dahulu");
                return;
            }

            document.getElementById("loadingOverlay").style.display = "flex";

            try {
                const formData = new FormData(
                    document.getElementById("salesForm")
                );
                cart.forEach((item, index) => {
                    formData.append(
                        `detil_penjualan[${index}][id_barang]`,
                        item.idBarang
                    );
                    formData.append(
                        `detil_penjualan[${index}][jml_barang]`,
                        item.jumlahBarang
                    );
                    formData.append(
                        `detil_penjualan[${index}][harga_satuan]`,
                        item.hargaSatuan
                    );
                });

                const response = await fetch(
                    document.getElementById("salesForm").action,
                    {
                        method: "POST",
                        body: formData,
                        headers: {
                            "X-CSRF-TOKEN": document.querySelector(
                                'meta[name="csrf-token"]'
                            ).content,
                            Accept: "application/json",
                        },
                    }
                );

                if (!response.ok) {
                    const errorData = await response.json();
                    throw new Error(
                        errorData.message || "Network response was not ok"
                    );
                }

                const data = await response.json();

                if (!data.success) {
                    throw new Error(data.message || "Transaksi gagal disimpan");
                }

                if (!data.id_transaksi) {
                    throw new Error(
                        "ID transaksi tidak ditemukan dalam response"
                    );
                }

                // Open the invoice in a new window
                window.open(`/invoice/${data.id_transaksi}`, "_blank");
            } catch (error) {
                console.error("Error:", error);
                alert("Error: " + error.message);
            } finally {
                document.getElementById("loadingOverlay").style.display =
                    "none";
            }
        });

    // Form submission
    document
        .getElementById("salesForm")
        .addEventListener("submit", function (e) {
            e.preventDefault();

            if (cart.length === 0) {
                alert(
                    "Keranjang kosong. Silakan tambahkan barang terlebih dahulu."
                );
                return;
            }

            // Show loading
            document.getElementById("loadingOverlay").style.display = "flex";

            // Prepare form data
            const formData = new FormData(this);
            cart.forEach((item, index) => {
                formData.append(
                    `detil_penjualan[${index}][id_barang]`,
                    item.idBarang
                );
                formData.append(
                    `detil_penjualan[${index}][jml_barang]`,
                    item.jumlahBarang
                );
                formData.append(
                    `detil_penjualan[${index}][harga_satuan]`,
                    item.hargaSatuan
                );
            });

            // Submit data
            fetch(this.action, {
                method: "POST",
                body: formData,
                headers: {
                    "X-CSRF-TOKEN": document.querySelector(
                        'meta[name="csrf-token"]'
                    ).content,
                    Accept: "application/json",
                },
            })
                .then((response) => {
                    if (!response.ok) {
                        return response.json().then((err) => {
                            throw err;
                        });
                    }
                    return response.json();
                })
                .then((data) => {
                    if (data.success) {
                        // Setelah transaksi berhasil, tunggu detik lalu refresh halaman
                        setTimeout(() => {
                            window.location.reload();
                        }, 300);
                    } else {
                        throw new Error(
                            data.message || "Transaksi gagal disimpan"
                        );
                    }
                })
                .catch((error) => {
                    console.error("Error:", error);
                    alert(
                        error.message ||
                            "Terjadi kesalahan saat menyimpan transaksi"
                    );
                    document.getElementById("loadingOverlay").style.display =
                        "none";
                });
        });

    document
        .getElementById("save-print-button")
        .addEventListener("click", async function (e) {
            e.preventDefault();

            if (cart.length === 0) {
                alert(
                    "Keranjang kosong. Silakan tambahkan barang terlebih dahulu."
                );
                return;
            }

            document.getElementById("loadingOverlay").style.display = "flex";

            try {
                const formData = new FormData(
                    document.getElementById("salesForm")
                );
                cart.forEach((item, index) => {
                    formData.append(
                        `detil_penjualan[${index}][id_barang]`,
                        item.idBarang
                    );
                    formData.append(
                        `detil_penjualan[${index}][jml_barang]`,
                        item.jumlahBarang
                    );
                    formData.append(
                        `detil_penjualan[${index}][harga_satuan]`,
                        item.hargaSatuan
                    );
                });

                const response = await fetch(
                    document.getElementById("salesForm").action,
                    {
                        method: "POST",
                        body: formData,
                        headers: {
                            "X-CSRF-TOKEN": document.querySelector(
                                'meta[name="csrf-token"]'
                            ).content,
                            Accept: "application/json",
                        },
                    }
                );

                if (!response.ok) {
                    const errorData = await response.json();
                    throw new Error(
                        errorData.message || "Network response was not ok"
                    );
                }

                const data = await response.json();

                if (!data.success) {
                    throw new Error(data.message || "Transaksi gagal disimpan");
                }

                if (!data.id_transaksi) {
                    throw new Error(
                        "ID transaksi tidak ditemukan dalam response"
                    );
                }

                // Buka window baru untuk cetak
                const printWindow = window.open(
                    `/invoice/print/${data.id_transaksi}`,
                    "_blank"
                );

                // Set timeout untuk memastikan window sudah terbuka sepenuhnya
                setTimeout(() => {
                    if (printWindow) {
                        printWindow.onload = function () {
                            printWindow.print();
                            // Tutup window setelah cetak (opsional)
                            setTimeout(() => {
                                printWindow.close();
                            }, 500);
                        };
                    }
                    window.location.reload();
                }, 1000);
            } catch (error) {
                console.error("Error:", error);
                alert("Error: " + error.message);
            } finally {
                document.getElementById("loadingOverlay").style.display =
                    "none";
            }
        });
});
