import{L as S}from"./Layout.191cffe8.js";import{L as w,H as D,j as U,r as b,o as s,c as l,a as u,w as g,b as o,k as j,l as _,v as f,n as m,F as y,d as H,t as c,e as n,m as v,h as M,f as E,g as P}from"./app.5e941448.js";import{S as L}from"./sweetalert2.all.e1cbbc39.js";import{E as N}from"./Editor.d901b863.js";import{M as A}from"./vue3-multiselect.css_vue_type_style_index_0_src_true_lang.9cd898d7.js";import{a as p}from"./index.6919478d.js";import{_ as B}from"./_plugin-vue_export-helper.cdc0426e.js";const K={layout:S,components:{Link:w,Head:D,Editor:N,Multiselect:A},props:{errors:Object,voucher:Object,categories:Object,subCategories:Object,memberCategories:Object},setup(a){const e=U({code:a.voucher.code,category_id:a.voucher.category_id,name:a.voucher.name,user_limit:a.voucher.user_limit,type:a.voucher.type,active_period:a.voucher.active_period,period_type:a.voucher.period_type,price_before_discount:a.voucher.price_before_discount,price_after_discount:a.voucher.price_after_discount,description:a.voucher.description,sub_category_ids:a.subCategories,is_active:a.voucher.is_active,member_categories:a.voucher.member_categories?a.voucher.member_categories.map(d=>({name:d})):[],subCategories:[]});return p.get(`/admin/categories/${e.category_id}/sub-categories`).then(d=>{e.subCategories=d.data}).catch(d=>console.error(d)),{form:e,submit:()=>{M.Inertia.put(`/admin/vouchers/${a.voucher.id}`,{code:e.code,name:e.name,category_id:e.category_id,user_limit:e.user_limit,type:e.type,active_period:e.active_period,period_type:e.period_type,price_before_discount:e.price_before_discount,price_after_discount:e.price_after_discount,description:e.description,is_active:e.is_active,sub_category_ids:e.sub_category_ids,member_categories:e.member_categories},{onSuccess:()=>{L.fire({title:"Success!",text:"Voucher Berhasil Diupdate!.",icon:"success",showConfirmButton:!1,timer:1e3})}})},subCategoryData:()=>{p.get(`/admin/categories/${e.category_id}/sub-categories`).then(d=>{e.sub_category_ids=[],e.subCategories=d.data}).catch(d=>console.error(d))}}}},O={class:"page-wrapper"},T={class:"page-content"},z=E('<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3"><div class="breadcrumb-title pe-3">Voucher</div><div class="ps-3"><nav aria-label="breadcrumb"><ol class="breadcrumb mb-0 p-0"><li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a></li><li class="breadcrumb-item active" aria-current="page">Edit Voucher</li></ol></nav></div></div>',1),F={class:"card border-top border-0 border-3 border-primary"},I={class:"card-body"},q={class:"d-lg-flex align-items-center"},G={class:"ms-auto"},J={class:"col-12"},Q=o("label",{class:"form-label"},"Kategori Peminatan",-1),R=o("option",{value:""},"[ Pilih ]",-1),W=["value"],X={key:0,class:"invalid-feedback"},Y={class:"col-12"},Z=o("label",{class:"form-label"},"Sub Kategori Peminatan",-1),$={class:"col-12"},ee=o("label",{class:"form-label"},"Kategori Member",-1),oe={key:0,class:"invalid-feedback"},te={class:"col-12"},ie=o("label",{class:"form-label"},"Nama Voucher",-1),re={key:0,class:"invalid-feedback"},ae={class:"col-12"},se=o("label",{class:"form-label"},"Masa Aktif",-1),le={key:0,class:"invalid-feedback"},ce={class:"col-12"},de=o("label",{class:"form-label"},"Tipe Periode Masa Aktif",-1),ne=o("option",{value:""},"[ Pilih ]",-1),me=o("option",{value:"day"},"Hari",-1),_e=o("option",{value:"month"},"Bulan",-1),ue=[ne,me,_e],be={key:0,class:"invalid-feedback"},ve={class:"col-12"},fe=o("label",{class:"form-label"},"Harga Sebelum Diskon",-1),he={key:0,class:"invalid-feedback"},ge={class:"col-12"},ye=o("label",{class:"form-label"},"Harga Sesudah Diskon",-1),pe={key:0,class:"invalid-feedback"},ke={class:"col-12"},Ve=o("label",{class:"form-label"},"Deskripsi",-1),xe={key:0},Ce={class:"col-12"},Se=o("label",{class:"form-label"},"Status",-1),we=o("option",{value:""},"[ Pilih ]",-1),De=o("option",{value:"1"},"Aktif",-1),Ue=o("option",{value:"0"},"Tidak Aktif",-1),je=[we,De,Ue],He={key:0,class:"invalid-feedback"},Me=o("div",{class:"col-12"},[o("button",{type:"submit",class:"btn btn-primary btn-sm px-5"},"Submit")],-1);function Ee(a,e,t,r,d,Pe){const k=b("Head"),V=b("Link"),h=b("multiselect"),x=b("Editor");return s(),l(y,null,[u(k,null,{default:g(()=>{var i;return[o("title",null,c((i=a.$page.props.setting.app_name)!=null?i:"Atur Setting Terlebih Dahulu")+" - Edit Voucher",1)]}),_:1}),o("div",O,[o("div",T,[z,o("div",F,[o("div",I,[o("div",q,[o("div",G,[u(V,{href:"/admin/vouchers",class:"btn btn-primary btn-sm mt-2 mt-lg-0"},{default:g(()=>[P("Kembali")]),_:1})])]),o("form",{onSubmit:e[11]||(e[11]=j((...i)=>r.submit&&r.submit(...i),["prevent"])),class:"row g-3"},[o("div",J,[Q,_(o("select",{onChange:e[0]||(e[0]=(...i)=>r.subCategoryData&&r.subCategoryData(...i)),"onUpdate:modelValue":e[1]||(e[1]=i=>r.form.category_id=i),class:m([{"is-invalid":t.errors.category_id},"form-select"])},[R,(s(!0),l(y,null,H(t.categories,(i,C)=>(s(),l("option",{key:C,value:i.id},c(i.name),9,W))),128))],34),[[f,r.form.category_id]]),t.errors.category_id?(s(),l("div",X,c(t.errors.category_id),1)):n("",!0)]),o("div",Y,[Z,u(h,{modelValue:r.form.sub_category_ids,"onUpdate:modelValue":e[2]||(e[2]=i=>r.form.sub_category_ids=i),options:r.form.subCategories,multiple:!0,label:"name","close-on-select":!0,"allow-empty":!0,"track-by":"id",placeholder:"[ Pilih ]"},null,8,["modelValue","options"])]),o("div",$,[ee,u(h,{modelValue:r.form.member_categories,"onUpdate:modelValue":e[3]||(e[3]=i=>r.form.member_categories=i),class:m({"is-invalid":t.errors.member_categories}),options:t.memberCategories,multiple:!0,label:"name","close-on-select":!0,"allow-empty":!0,"track-by":"name",placeholder:"[ Pilih ]"},null,8,["modelValue","class","options"]),t.errors.member_categories?(s(),l("div",oe,c(t.errors.member_categories),1)):n("",!0)]),o("div",te,[ie,_(o("input",{type:"text",class:m(["form-control",{"is-invalid":t.errors.name}]),"onUpdate:modelValue":e[4]||(e[4]=i=>r.form.name=i),placeholder:"Nama Voucher"},null,2),[[v,r.form.name]]),t.errors.name?(s(),l("div",re,c(t.errors.name),1)):n("",!0)]),o("div",ae,[se,_(o("input",{type:"number",class:m(["form-control",{"is-invalid":t.errors.active_period}]),"onUpdate:modelValue":e[5]||(e[5]=i=>r.form.active_period=i),placeholder:"Masa Keaktifan"},null,2),[[v,r.form.active_period]]),t.errors.active_period?(s(),l("div",le,c(t.errors.active_period),1)):n("",!0)]),o("div",ce,[de,_(o("select",{"onUpdate:modelValue":e[6]||(e[6]=i=>r.form.period_type=i),class:m([{"is-invalid":t.errors.period_type},"form-select"])},ue,2),[[f,r.form.period_type]]),t.errors.period_type?(s(),l("div",be,c(t.errors.period_type),1)):n("",!0)]),o("div",ve,[fe,_(o("input",{type:"number",class:m(["form-control",{"is-invalid":t.errors.price_before_discount}]),"onUpdate:modelValue":e[7]||(e[7]=i=>r.form.price_before_discount=i),placeholder:"Harga Sebelum Diskon"},null,2),[[v,r.form.price_before_discount]]),t.errors.price_before_discount?(s(),l("div",he,c(t.errors.price_before_discount),1)):n("",!0)]),o("div",ge,[ye,_(o("input",{type:"number",class:m(["form-control",{"is-invalid":t.errors.price_after_discount}]),"onUpdate:modelValue":e[8]||(e[8]=i=>r.form.price_after_discount=i),placeholder:"Harga Sesudah Diskon"},null,2),[[v,r.form.price_after_discount]]),t.errors.price_after_discount?(s(),l("div",pe,c(t.errors.price_after_discount),1)):n("",!0)]),o("div",ke,[Ve,u(x,{"api-key":"ks7buom19yw30zn9i2t0x36p1j5yn8mch71i5ek9fz9xpivd",modelValue:r.form.description,"onUpdate:modelValue":e[9]||(e[9]=i=>r.form.description=i),init:{images_upload_url:"/upload",automatic_uploads:!0,height:400,plugins:["advlist autolink lists link image charmap print preview hr anchor pagebreak","searchreplace wordcount visualblocks visualchars code fullscreen","insertdatetime media nonbreaking save table contextmenu directionality","emoticons template paste textcolor colorpicker textpattern imagetools"],toolbar:"insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | print preview media | forecolor backcolor emoticons",image_advtab:!0}},null,8,["modelValue"]),t.errors.description?(s(),l("div",xe,c(t.errors.description),1)):n("",!0)]),o("div",Ce,[Se,_(o("select",{"onUpdate:modelValue":e[10]||(e[10]=i=>r.form.is_active=i),class:m([{"is-invalid":t.errors.is_active},"form-select"])},je,2),[[f,r.form.is_active]]),t.errors.is_active?(s(),l("div",He,c(t.errors.is_active),1)):n("",!0)]),Me],32)])])])])],64)}const ze=B(K,[["render",Ee]]);export{ze as default};