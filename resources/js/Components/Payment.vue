<template>
    <button @click="pay">Bayar Sekarang</button>
  </template>
  
  <script>
  import midtransClient from 'midtrans-client';
  
  export default {
    methods: {
      pay() {
        var snap = new midtransClient.Snap({
          isProduction: false,
          serverKey: 'Mid-server-pB77pujDpt9DlYmqtwENceTH', // Ganti dengan server key Midtrans Anda
        });
  
        snap.createTransaction({
          token: '{{ $snapToken }}',
          onSuccess: function(result) {
            // Redirect ke halaman sukses
            window.location.href = "{{ route('home') }}";
          },
          onPending: function(result) {
            // Redirect ke halaman pending
            window.location.href = "{{ route('home') }}";
          },
          onError: function(result) {
            // Redirect ke halaman error
            window.location.href = "{{ route('home') }}";
          }
        });
      }
    }
  }
  </script>