import{L as w}from"./Layout.8ad13794.js";import{P as S}from"./Pagination.f94e0a46.js";import{L as M,H as L,r as y,o as s,c as t,a as c,w as d,b as r,e as i,F as b,d as m,h as B,f as k,t as a,g as l,K as T,n as j}from"./app.403a0689.js";import{S as P}from"./sweetalert2.all.70162e3b.js";import{_ as H}from"./_plugin-vue_export-helper.cdc0426e.js";const K={layout:w,components:{Link:M,Head:L,Pagination:S},props:{exams:Object,categoryId:Object,lessonCategoryId:Object,lessonId:Object,userMemberCategories:Object},setup(o){return{buyExam:n=>{P.fire({title:"Anda yakin akan membeli Latihan Soal ini ?",text:"Pastikan Saldo Anda Cukup Untuk Bertransaksi",icon:"warning",showCancelButton:!0,confirmButtonColor:"#3085d6",cancelButtonColor:"#d33",confirmButtonText:"Ya, Beli Latihan Soal",cancelButtonText:"Tidak"}).then(p=>{p.isConfirmed&&B.Inertia.get(`/user/account-balances/buy-exam/${n}?type=exam`)})},checkMemberCategories:n=>{if(n){for(const p of o.userMemberCategories)if(p.member_categories.some(h=>n.includes(h)))return!0;return!1}else return!0}}},methods:{formatPrice(o){return(o/1).toFixed().replace(".",",").toString().replace(/\B(?=(\d{3})+(?!\d))/g,".")}}},I={class:"page-wrapper"},N={class:"page-content"},A={class:"page-breadcrumb d-none d-sm-flex align-items-center mb-3"},E=k('<div class="breadcrumb-title pe-3">Latihan Soal</div><div class="ps-3"><nav aria-label="breadcrumb"><ol class="breadcrumb mb-0 p-0"><li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a></li><li class="breadcrumb-item active" aria-current="page">Soal</li></ol></nav></div>',2),O={class:"ms-auto"},U=r("hr",null,null,-1),V={key:0},F=k('<div class="row row-cols-12 row-cols-md-12 row-cols-lg-12 row-cols-xl-12"><div class="col"><div class="card border-bottom border-3 border-0"><div class="card-body"><h5 class="card-title text-center">Soal Belum Tersedia.</h5></div></div></div></div>',1),R=[F],z={class:"row"},D={class:"col-lg-12"},Y={key:0,class:"alert alert-danger border-0"},q=["innerHTML"],G={key:1,class:"alert alert-danger border-0"},J=["innerHTML"],Q={key:2,class:"alert alert-success border-0"},W=["innerHTML"],X={class:"card"},Z={key:0},x={key:0,class:"badge bg-danger",style:{position:"absolute","font-size":"14px",margin:"4px"}},ee={class:"p-2"},se=["src"],te={class:"card-header"},re={class:"card-title"},oe={key:1,class:"card-body"},ie={key:0,style:{"min-height":"50px"}},ne={key:0},ae={class:"card-price text-center"},ce={key:1},de={class:"text-dark text-center"},le={class:"badge bg-danger mx-1"},_e=r("br",null,null,-1),ue={key:1,class:"text-center"},ge={key:0},he={class:"badge bg-success mb-0 ms-1"},be={key:1},pe=r("span",{class:"badge bg-success mb-0"},"Seluruh Member & Non Member",-1),me=[pe],ye={class:"card-footer"},ve={key:0},ke={key:0},fe={key:0},$e={key:0},Ce={key:1},we=["onClick"],Se={key:1},Me={key:0},Le={key:1},Be={key:0},Te={key:1},je={key:2},Pe={key:0},He={key:1},Ke={key:2},Ie=["onClick"],Ne={key:3},Ae={key:0},Ee={key:1},Oe={key:1},Ue={key:1},Ve={key:1,class:"row mb-3"},Fe={class:"col"};function Re(o,v,u,n,p,h){const f=y("Head"),_=y("Link"),$=y("Pagination");return s(),t(b,null,[c(f,null,{default:d(()=>{var e;return[r("title",null,a((e=o.$page.props.setting.app_name)!=null?e:"Atur Setting Terlebih Dahulu")+" - Soal",1)]}),_:1}),r("div",I,[r("div",N,[r("div",A,[E,r("div",O,[c(_,{href:`/user/categories/${u.categoryId}/lesson-categories/${u.lessonCategoryId}/lessons`,class:"btn btn-primary btn-sm mt-2 mt-lg-0"},{default:d(()=>[l("Kembali")]),_:1},8,["href"])])]),U,u.exams.data.length?i("",!0):(s(),t("div",V,R)),r("div",z,[r("div",D,[o.$page.props.session.failed?(s(),t("div",Y,[r("div",{innerHTML:o.$page.props.session.failed},null,8,q)])):i("",!0),o.$page.props.session.error?(s(),t("div",G,[r("div",{innerHTML:o.$page.props.session.error},null,8,J)])):i("",!0),o.$page.props.session.success?(s(),t("div",Q,[r("div",{innerHTML:o.$page.props.session.success},null,8,W)])):i("",!0)]),(s(!0),t(b,null,m(u.exams.data,(e,C)=>(s(),t("div",{class:"col-xs-12 col-sm-6 col-md-6 col-lg-3",key:C},[r("div",X,[o.$page.props.auth.user.member_type==2?(s(),t("div",Z,[(e.transaction.length>0||n.checkMemberCategories(e.member_categories)==!0)&&e.member_categories?(s(),t("span",x)):i("",!0)])):i("",!0),r("div",ee,[r("img",{src:"/storage/upload_files/lessons/"+e.lesson.thumbnail,class:"card-img"},null,8,se)]),r("div",te,[r("h6",re,a(e.title),1)]),o.$page.props.auth.user.member_type==2?(s(),t("div",oe,[o.$page.props.setting.purchase_type==1||o.$page.props.setting.purchase_type==3?(s(),t("div",ie,[e.price_before_discount==e.price_after_discount?(s(),t("div",ne,[r("h6",ae,"Rp."+a(h.formatPrice(e.price_after_discount)),1)])):(s(),t("div",ce,[r("h6",de,[r("sup",null,[r("s",null,"Rp."+a(h.formatPrice(e.price_before_discount)),1),r("span",le,a(h.formatPrice((e.price_before_discount-e.price_after_discount)/e.price_before_discount*100))+"% ",1)]),_e,l("Rp."+a(h.formatPrice(e.price_after_discount)),1)])]))])):i("",!0),o.$page.props.setting.purchase_type==2||o.$page.props.setting.purchase_type==3?(s(),t("div",ue,[e.member_categories?(s(),t("div",ge,[(s(!0),t(b,null,m(e.member_categories,g=>(s(),t("span",he,a(g),1))),256))])):(s(),t("div",be,me))])):i("",!0)])):i("",!0),r("div",ye,[e.exam_status=="active"?(s(),t("div",ve,[o.$page.props.auth.user.member_type==2?(s(),t("div",ke,[o.$page.props.setting.purchase_type==1?(s(),t("div",fe,[e.transaction.length>0?(s(),t("div",$e,[c(_,{href:`/user/categories/${e.category_id}/lesson-categories/${e.lesson_category_id}/lessons/${e.lesson_id}/exams/${e.id}`,class:"btn btn-primary btn-sm w-100"},{default:d(()=>[l("Kerjakan Soal")]),_:2},1032,["href"])])):(s(),t("div",Ce,[r("button",{class:"btn btn-outline-primary btn-sm w-100",onClick:g=>n.buyExam(e.id)},"Beli Latihan Soal",8,we)]))])):i("",!0),o.$page.props.setting.purchase_type==2?(s(),t("div",Se,[n.checkMemberCategories(e.member_categories)==!0?(s(),t("div",Me,[e.exam_status=="active"?(s(),T(_,{key:0,href:`/user/categories/${e.category_id}/lesson-categories/${e.lesson_category_id}/lessons/${e.lesson_id}/exams/${e.id}`,class:"btn btn-primary btn-sm w-100"},{default:d(()=>[l("Kerjakan Soal")]),_:2},1032,["href"])):i("",!0)])):(s(),t("div",Le,[c(_,{href:`/user/vouchers?category_id=${e.category_id}`,class:"btn btn-outline-primary btn-sm w-100"},{default:d(()=>[e.member_categories.length==1?(s(),t("div",Be,[l(" Upgrade Ke "),(s(!0),t(b,null,m(e.member_categories,g=>(s(),t("span",null,a(g),1))),256))])):(s(),t("div",Te," Upgrade Member "))]),_:2},1032,["href"])]))])):i("",!0),o.$page.props.setting.purchase_type==3?(s(),t("div",je,[e.transaction.length>0&&n.checkMemberCategories(e.member_categories)==!0?(s(),t("div",Pe,[c(_,{href:`/user/categories/${e.category_id}/lesson-categories/${e.lesson_category_id}/lessons/${e.lesson_id}/exams/${e.id}`,class:"btn btn-primary btn-sm w-100 mb-2"},{default:d(()=>[l("Kerjakan Soal")]),_:2},1032,["href"])])):i("",!0),(e.transaction.length==0||n.checkMemberCategories(e.member_categories)==!1)&&(e.transaction.length>0||n.checkMemberCategories(e.member_categories)==!0)?(s(),t("div",He,[c(_,{href:`/user/categories/${e.category_id}/lesson-categories/${e.lesson_category_id}/lessons/${e.lesson_id}/exams/${e.id}`,class:"btn btn-primary btn-sm w-100 mb-2"},{default:d(()=>[l("Kerjakan Soal")]),_:2},1032,["href"])])):i("",!0),e.transaction.length==0?(s(),t("div",Ke,[r("button",{class:"btn btn-outline-primary btn-sm w-100 mb-2",onClick:g=>n.buyExam(e.id)},"Beli Latihan Soal",8,Ie)])):i("",!0),n.checkMemberCategories(e.member_categories)==!1?(s(),t("div",Ne,[c(_,{href:`/user/vouchers?category_id=${e.category_id}`,class:"btn btn-outline-primary btn-sm w-100 mb-2"},{default:d(()=>[e.member_categories.length==1?(s(),t("div",Ae,[l(" Upgrade Ke "),(s(!0),t(b,null,m(e.member_categories,g=>(s(),t("span",null,a(g),1))),256))])):(s(),t("div",Ee," Upgrade Member "))]),_:2},1032,["href"])])):i("",!0)])):i("",!0)])):(s(),t("div",Oe,[c(_,{href:`/user/categories/${e.category_id}/lesson-categories/${e.lesson_category_id}/lessons/${e.lesson_id}/exams/${e.id}`,class:"btn btn-primary btn-sm w-100"},{default:d(()=>[l("Kerjakan Soal")]),_:2},1032,["href"])]))])):(s(),t("div",Ue,[r("button",{class:j(["btn btn-sm w-100",{"btn-danger":e.exam_status=="inactive","btn-warning":e.exam_status==="inprogress"}])},a(e.exam_status==="inactive"?"Non Active":"In Progress"),3)]))])])]))),128))]),u.exams.data.length?(s(),t("div",Ve,[r("div",Fe,[c($,{links:u.exams.links,align:"center"},null,8,["links"])])])):i("",!0)])])],64)}const Je=H(K,[["render",Re]]);export{Je as default};