document.addEventListener('DOMContentLoaded', function() {
    // Simulasi data dummy
    const data = {
        onlineOrders: 150,
        totalOnlineOrders: 500,
        directSales: 300,
        totalRevenue: 10000,
        directSalesData: [50, 75, 100, 120, 90, 110, 80],
        onlineOrdersData: [30, 40, 60, 80, 120, 90, 100]
    };

    // Update konten dashboard dengan data dummy
    document.getElementById('onlineOrders').innerText = data.onlineOrders;
    document.getElementById('totalOnlineOrders').innerText = data.totalOnlineOrders;
    document.getElementById('directSales').innerText = data.directSales;
    document.getElementById('totalRevenue').innerText = data.totalRevenue;

    // Inisialisasi grafik penjualan langsung
    const directSalesChart = new Chart(document.getElementById('directSalesChart').getContext('2d'), {
        type: 'line',
        data: {
            labels: ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'],
            datasets: [{
                label: 'Penjualan Langsung per Hari',
                data: data.directSalesData,
                borderColor: 'rgb(75, 192, 192)',
                fill: false
            }]
        }
    });

    // Inisialisasi grafik pemesanan online
    const onlineOrdersChart = new Chart(document.getElementById('onlineOrdersChart').getContext('2d'), {
        type: 'line',
        data: {
            labels: ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'],
            datasets: [{
                label: 'Pemesanan Online per Hari',
                data: data.onlineOrdersData,
                borderColor: 'rgb(255, 99, 132)',
                fill: false
            }]
        }
    });
});
