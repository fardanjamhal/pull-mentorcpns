import{L as f}from"./Layout.70398840.js";import{L as g,H as k,j as T,r,o,c as i,a as _,w as m,b as t,k as S,t as n,e as u,l as y,v as p,F as x,h as w,f as h,g as D}from"./app.6cf705fe.js";import{S as L}from"./sweetalert2.all.76868986.js";import{_ as N}from"./_plugin-vue_export-helper.cdc0426e.js";const K={layout:f,components:{Link:g,Head:k},props:{accountBalance:Object},setup(s){const e=T({transaction_status:s.accountBalance.transaction_status});return{form:e,submit:()=>{w.Inertia.put(`/admin/account-balances/${s.accountBalance.id}`,{transaction_status:e.transaction_status},{onSuccess:()=>{L.fire({title:"Success!",text:"Transaksi Berhasil Diupdate!.",icon:"success",showConfirmButton:!1,timer:1e3})}})}}},methods:{formatPrice(s){return"Rp."+(s/1).toFixed().replace(".",",").toString().replace(/\B(?=(\d{3})+(?!\d))/g,".")}}},P={class:"page-wrapper"},V={class:"page-content"},C=h('<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3"><div class="breadcrumb-title pe-3">Transaksi</div><div class="ps-3"><nav aria-label="breadcrumb"><ol class="breadcrumb mb-0 p-0"><li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a></li><li class="breadcrumb-item active" aria-current="page">Detail Transaksi</li></ol></nav></div></div>',1),F={class:"card border-top border-0 border-3 border-primary"},H={class:"card-body"},j={class:"d-lg-flex align-items-center"},A={class:"ms-auto"},U={class:"table-responsive"},E={class:"table mb-0"},M=t("tr",null,[t("th",{colspan:"3"},"Biodata")],-1),I=t("td",{width:"300px"},"Nama Lengkap",-1),O=t("td",{width:"20px"},":",-1),R=t("td",null,"Email",-1),W=t("td",null,":",-1),q=t("td",null,"Provinsi",-1),z=t("td",null,":",-1),G=t("td",null,"Kota/Kab",-1),J=t("td",null,":",-1),Q=t("td",null,"Kecamatan",-1),X=t("td",null,":",-1),Y=t("td",null,"Desa/Kelurahan",-1),Z=t("td",null,":",-1),$=t("td",null,"Nomor Telepon (Whatsapp)",-1),tt=t("td",null,":",-1),at=t("tr",null,[t("th",{colspan:"3"},"Detail Transaksi")],-1),nt=t("td",null,"Kode Transaksi",-1),et=t("td",null,":",-1),st=t("td",null,"Tanggal Transaksi",-1),ct=t("td",null,":",-1),lt=t("td",null,"Total Top Up",-1),ot=t("td",null,":",-1),it=t("td",null,"Status Transaksi",-1),ut=t("td",null,":",-1),dt={key:0},rt=t("th",{colspan:"3"},"Action",-1),_t=[rt],mt={key:1},ht=t("td",null,"Ubah Status Transaksi",-1),bt=t("td",null,":",-1),Bt=h('<option value="">[ Pilih Status Transaksi ]</option><option value="pending">Pending</option><option value="paid">Paid</option><option value="done">Done</option><option value="failed">Failed</option>',5),vt=[Bt],ft={key:2},gt=t("td",{colspan:"3"},[t("button",{type:"submit",class:"btn btn-primary btn-sm px-5"},"Submit")],-1),kt=[gt];function Tt(s,e,a,l,St,b){var d;const B=r("Head"),v=r("Link");return o(),i(x,null,[_(B,null,{default:m(()=>{var c;return[t("title",null,n((c=s.$page.props.setting.app_name)!=null?c:"Atur Setting Terlebih Dahulu")+" - Detail Transaksi",1)]}),_:1}),t("div",P,[t("div",V,[C,t("div",F,[t("div",H,[t("div",j,[t("div",A,[_(v,{href:"/admin/account-balances",class:"btn btn-primary btn-sm mt-2 mt-lg-0"},{default:m(()=>[D("Kembali")]),_:1})])]),t("div",U,[t("form",{onSubmit:e[1]||(e[1]=S((...c)=>l.submit&&l.submit(...c),["prevent"]))},[t("table",E,[t("tbody",null,[M,t("tr",null,[I,O,t("td",null,n(a.accountBalance.user.name),1)]),t("tr",null,[R,W,t("td",null,n((d=a.accountBalance.user.email)!=null?d:"-"),1)]),t("tr",null,[q,z,t("td",null,n(a.accountBalance.user&&a.accountBalance.user.student&&a.accountBalance.user.student.province?a.accountBalance.user.student.province.name:"-"),1)]),t("tr",null,[G,J,t("td",null,n(a.accountBalance.user&&a.accountBalance.user.student&&a.accountBalance.user.student.city?a.accountBalance.user.student.city.name:"-"),1)]),t("tr",null,[Q,X,t("td",null,n(a.accountBalance.user&&a.accountBalance.user.student&&a.accountBalance.user.student.district?a.accountBalance.user.student.district.name:"-"),1)]),t("tr",null,[Y,Z,t("td",null,n(a.accountBalance.user&&a.accountBalance.user.student&&a.accountBalance.user.student.village?a.accountBalance.user.student.village.name:"-"),1)]),t("tr",null,[$,tt,t("td",null,n(a.accountBalance.user&&a.accountBalance.user.student&&a.accountBalance.user.student.phone_number?a.accountBalance.user.student.phone_number:"-"),1)]),at,t("tr",null,[nt,et,t("td",null,n(a.accountBalance.code),1)]),t("tr",null,[st,ct,t("td",null,n(a.accountBalance.created_at),1)]),t("tr",null,[lt,ot,t("td",null,n(b.formatPrice(a.accountBalance.top_up_balance)),1)]),t("tr",null,[it,ut,t("td",null,n(a.accountBalance.transaction_status),1)]),a.accountBalance.transaction_status!="done"?(o(),i("tr",dt,_t)):u("",!0),a.accountBalance.transaction_status!="done"?(o(),i("tr",mt,[ht,bt,t("td",null,[y(t("select",{class:"form-control","onUpdate:modelValue":e[0]||(e[0]=c=>l.form.transaction_status=c)},vt,512),[[p,l.form.transaction_status]])])])):u("",!0),a.accountBalance.transaction_status!="done"?(o(),i("tr",ft,kt)):u("",!0)])])],32)])])])])])],64)}const Dt=N(K,[["render",Tt]]);export{Dt as default};