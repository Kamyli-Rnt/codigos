function mascara(i, t) {
   var v = i.value.replace(/\D/g, ''); // Remove todos os não dígitos da entrada

   if (t === "data") {
       if (v.length <= 2) { 
           i.value = v;
       } else if (v.length <= 4) {
           i.value = v.substring(0, 2) + '/' + v.substring(2);
       } else {
           i.value = v.substring(0, 2) + '/' + v.substring(2, 4) + '/' + v.substring(4, 8);
       }
   } else if (t === "cpf_clie") {
       if (v.length <= 3) {
           i.value = v;
       } else if (v.length <= 6) {
           i.value = v.substring(0, 3) + '.' + v.substring(3);
       } else if (v.length <= 9) {
           i.value = v.substring(0, 3) + '.' + v.substring(3, 6) + '.' + v.substring(6);
       } else {
           i.value = v.substring(0, 3) + '.' + v.substring(3, 6) + '.' + v.substring(6, 9) + '-' + v.substring(9, 11);
       }
   } else if (t === "telefone_clie") {
       if (v.length <= 2) {
           i.value = '(' + v;
       } else if (v.length <= 7) {
           i.value = '(' + v.substring(0, 2) + ') ' + v.substring(2);
       } else if (v.length <= 11) {
           i.value = '(' + v.substring(0, 2) + ') ' + v.substring(2, 7) + '-' + v.substring(7);
       } else {
           i.value = '(' + v.substring(0, 2) + ') ' + v.substring(2, 7) + '-' + v.substring(7, 11);
       }
   }
}