import{L as w}from"./Layout.1d0436f6.js";import{P as M}from"./Pagination.e1c36b53.js";import{L as O,H as $,r as y,o as s,c as t,a as c,w as l,b as r,e as a,F as h,d as p,h as B,f,t as d,g as _,n as L}from"./app.03e893b1.js";import{S as P}from"./sweetalert2.all.290c8573.js";import{_ as S}from"./_plugin-vue_export-helper.cdc0426e.js";const j={layout:w,components:{Link:O,Head:$,Pagination:M},props:{examGroups:Object,lessonCategory:Object,userMemberCategories:Object},setup(o){return{buyExam:i=>{P.fire({title:"yakin akan membeli Try Out ?",text:"Pastikan Saldo Anda Cukup Untuk Transaksi",icon:"warning",showCancelButton:!0,confirmButtonColor:"#3085d6",cancelButtonColor:"#d33",confirmButtonText:"Ya, Beli Try Out",cancelButtonText:"Tidak"}).then(m=>{m.isConfirmed&&B.Inertia.get(`/user/account-balances/buy-exam/${i}?type=examGroup`)})},checkMemberCategories:i=>{if(i){for(const m of o.userMemberCategories)if(m.member_categories.some(b=>i.includes(b)))return!0;return!1}else return!0}}},methods:{formatPrice(o){return(o/1).toFixed().replace(".",",").toString().replace(/\B(?=(\d{3})+(?!\d))/g,".")}}},H={class:"page-wrapper"},K={class:"page-content"},E={class:"page-breadcrumb d-none d-sm-flex align-items-center mb-3"},N=f('<div class="breadcrumb-title pe-3">Try Out</div><div class="ps-3"><nav aria-label="breadcrumb"><ol class="breadcrumb mb-0 p-0"><li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a></li><li class="breadcrumb-item active" aria-current="page">Soal Try Out</li></ol></nav></div>',2),G={class:"ms-auto"},A=r("hr",null,null,-1),U={key:0},V=f('<div class="row row-cols-12 row-cols-md-12 row-cols-lg-12 row-cols-xl-12"><div class="col"><div class="card border-bottom border-3 border-0"><div class="card-body"><h5 class="card-title text-center">Soal Belum Tersedia.</h5></div></div></div></div>',1),D=[V],F={class:"row"},I={class:"col-lg-12"},R={key:0,class:"alert alert-danger border-0"},z=["innerHTML"],Y={key:1,class:"alert alert-danger border-0"},q=["innerHTML"],J={key:2,class:"alert alert-success border-0"},Q=["innerHTML"],W={class:"card border-bottom border-3 border-0"},X={key:0},Z={key:0,class:"badge bg-danger",style:{position:"absolute","font-size":"14px",margin:"4px"}},x={class:"p-2"},ee=["src"],se={class:"card-header"},te={class:"card-title"},re=r("p",{class:"card-text"},"Kerjakan Try Out Sesuai Perintah Yang Ada Dalam Informasi.",-1),oe={key:1,class:"card-body"},ae={key:0,style:{"min-height":"50px"}},ne={key:0},ie={class:"card-price text-center"},ce={key:1},de={class:"text-dark text-center"},le={class:"badge bg-danger mx-1"},_e=r("br",null,null,-1),ue={key:1,class:"text-center"},ge={key:0},be={class:"badge bg-success mb-0 ms-1"},he={key:1},me=r("span",{class:"badge bg-success mb-0"},"Seluruh Member & Non Member",-1),pe=[me],ye={class:"card-footer"},ve={key:0},fe={key:0},ke={key:0},Ce={key:0},Te={key:1},we=["onClick"],Me={key:1},Oe={key:0},$e={key:1},Be={key:0},Le={key:1},Pe={key:2},Se={key:0},je={key:1},He={key:2},Ke=["onClick"],Ee={key:3},Ne={key:0},Ge={key:1},Ae={key:1},Ue={key:1},Ve={key:1,class:"row"},De={class:"col"},Fe=r("br",null,null,-1),Ie=r("br",null,null,-1);function Re(o,v,n,i,m,b){const k=y("Head"),u=y("Link"),C=y("Pagination");return s(),t(h,null,[c(k,null,{default:l(()=>{var e;return[r("title",null,d((e=o.$page.props.setting.app_name)!=null?e:"Atur Setting Terlebih Dahulu")+" - Try Out",1)]}),_:1}),r("div",H,[r("div",K,[r("div",E,[N,r("div",G,[c(u,{href:`/user/exam-groups/${n.lessonCategory.category_id}/lesson-categories`,class:"btn btn-primary btn-sm mt-2 mt-lg-0"},{default:l(()=>[_("Kembali")]),_:1},8,["href"])])]),A,n.examGroups.data.length?a("",!0):(s(),t("div",U,D)),r("div",F,[r("div",I,[o.$page.props.session.failed?(s(),t("div",R,[r("div",{innerHTML:o.$page.props.session.failed},null,8,z)])):a("",!0),o.$page.props.session.error?(s(),t("div",Y,[r("div",{innerHTML:o.$page.props.session.error},null,8,q)])):a("",!0),o.$page.props.session.success?(s(),t("div",J,[r("div",{innerHTML:o.$page.props.session.success},null,8,Q)])):a("",!0)]),(s(!0),t(h,null,p(n.examGroups.data,(e,T)=>(s(),t("div",{class:"col-xs-12 col-sm-6 col-md-6 col-lg-3",key:T},[r("div",W,[o.$page.props.auth.user.member_type==2?(s(),t("div",X,[(e.transaction.length>0||i.checkMemberCategories(e.member_categories)==!0)&&e.member_categories?(s(),t("span",Z,"Enrolled")):a("",!0)])):a("",!0),r("div",x,[r("img",{src:"/storage/upload_files/lesson_categories/"+e.lesson_category.thumbnail,class:"card-img"},null,8,ee)]),r("div",se,[r("h6",te,d(e.title),1),re]),o.$page.props.auth.user.member_type==2?(s(),t("div",oe,[o.$page.props.setting.purchase_type==1||o.$page.props.setting.purchase_type==3?(s(),t("div",ae,[e.price_before_discount==e.price_after_discount?(s(),t("div",ne,[r("h6",ie,"Rp."+d(b.formatPrice(e.price_after_discount)),1)])):(s(),t("div",ce,[r("h6",de,[r("sup",null,[r("s",null,"Rp."+d(b.formatPrice(e.price_before_discount)),1),r("span",le,d(b.formatPrice((e.price_before_discount-e.price_after_discount)/e.price_before_discount*100))+"% ",1)]),_e,_("Rp."+d(b.formatPrice(e.price_after_discount)),1)])]))])):a("",!0),o.$page.props.setting.purchase_type==2||o.$page.props.setting.purchase_type==3?(s(),t("div",ue,[e.member_categories?(s(),t("div",ge,[(s(!0),t(h,null,p(e.member_categories,g=>(s(),t("span",be,d(g),1))),256))])):(s(),t("div",he,pe))])):a("",!0)])):a("",!0),r("div",ye,[e.exam_status=="active"?(s(),t("div",ve,[o.$page.props.auth.user.member_type==2?(s(),t("div",fe,[o.$page.props.setting.purchase_type==1?(s(),t("div",ke,[e.transaction.length>0?(s(),t("div",Ce,[c(u,{href:`/user/exam-groups/${n.lessonCategory.category_id}/lesson-categories/${n.lessonCategory.id}/exams/${e.id}`,class:"btn btn-primary btn-sm w-100"},{default:l(()=>[_("Kerjakan Try Out")]),_:2},1032,["href"])])):(s(),t("div",Te,[r("button",{class:"btn btn-outline-primary btn-sm w-100",onClick:g=>i.buyExam(e.id)},"Beli Try Out",8,we)]))])):a("",!0),o.$page.props.setting.purchase_type==2?(s(),t("div",Me,[i.checkMemberCategories(e.member_categories)==!0?(s(),t("div",Oe,[c(u,{href:`/user/exam-groups/${n.lessonCategory.category_id}/lesson-categories/${n.lessonCategory.id}/exams/${e.id}`,class:"btn btn-primary btn-sm w-100"},{default:l(()=>[_("Kerjakan Try Out")]),_:2},1032,["href"])])):(s(),t("div",$e,[c(u,{href:`/user/vouchers?category_id=${e.category_id}`,class:"btn btn-outline-primary btn-sm w-100"},{default:l(()=>[e.member_categories.length==1?(s(),t("div",Be,[_(" Upgrade Ke "),(s(!0),t(h,null,p(e.member_categories,g=>(s(),t("span",null,d(g),1))),256))])):(s(),t("div",Le," Upgrade Member "))]),_:2},1032,["href"])]))])):a("",!0),o.$page.props.setting.purchase_type==3?(s(),t("div",Pe,[e.transaction.length>0&&i.checkMemberCategories(e.member_categories)==!0?(s(),t("div",Se,[c(u,{href:`/user/exam-groups/${n.lessonCategory.category_id}/lesson-categories/${n.lessonCategory.id}/exams/${e.id}`,class:"btn btn-primary btn-sm w-100 mb-2"},{default:l(()=>[_("Kerjakan Try Out")]),_:2},1032,["href"])])):a("",!0),(e.transaction.length==0||i.checkMemberCategories(e.member_categories)==!1)&&(e.transaction.length>0||i.checkMemberCategories(e.member_categories)==!0)?(s(),t("div",je,[c(u,{href:`/user/exam-groups/${n.lessonCategory.category_id}/lesson-categories/${n.lessonCategory.id}/exams/${e.id}`,class:"btn btn-primary btn-sm w-100 mb-2"},{default:l(()=>[_("Kerjakan Try Out")]),_:2},1032,["href"])])):a("",!0),e.transaction.length==0?(s(),t("div",He,[r("button",{class:"btn btn-outline-primary btn-sm w-100 mb-2",onClick:g=>i.buyExam(e.id)},"Beli Try Out",8,Ke)])):a("",!0),i.checkMemberCategories(e.member_categories)==!1?(s(),t("div",Ee,[c(u,{href:`/user/vouchers?category_id=${e.category_id}`,class:"btn btn-outline-primary btn-sm w-100 mb-2"},{default:l(()=>[e.member_categories.length==1?(s(),t("div",Ne,[_(" Upgrade Ke "),(s(!0),t(h,null,p(e.member_categories,g=>(s(),t("span",null,d(g),1))),256))])):(s(),t("div",Ge," Upgrade Member "))]),_:2},1032,["href"])])):a("",!0)])):a("",!0)])):(s(),t("div",Ae,[c(u,{href:`/user/exam-groups/${n.lessonCategory.category_id}/lesson-categories/${n.lessonCategory.id}/exams/${e.id}`,class:"btn btn-primary btn-sm w-100"},{default:l(()=>[_("Kerjakan Try Out")]),_:2},1032,["href"])]))])):(s(),t("div",Ue,[r("button",{class:L(["btn btn-sm w-100",{"btn-danger":e.exam_status=="inactive","btn-warning":e.exam_status==="inprogress"}])},d(e.exam_status==="inactive"?"Non Active":"In Progress"),3)]))])])]))),128))]),n.examGroups.data.length?(s(),t("div",Ve,[r("div",De,[c(C,{links:n.examGroups.links,align:"center"},null,8,["links"]),Fe,Ie])])):a("",!0)])])],64)}const We=S(j,[["render",Re]]);export{We as default};