import{L as y}from"./Layout.5c26fe42.js";import{L as M,H as V,j as x,r as u,o as l,c as r,a as b,w as v,b as e,k as w,l as n,v as S,n as c,F as f,d as j,t as d,e as m,m as _,h as L,f as C,g as B}from"./app.af577664.js";import{S as D}from"./sweetalert2.all.bc5b69d2.js";import{M as P}from"./vue3-multiselect.css_vue_type_style_index_0_src_true_lang.c7a4945e.js";import{_ as U}from"./_plugin-vue_export-helper.cdc0426e.js";const K={layout:y,components:{Link:M,Head:V,Multiselect:P},props:{errors:Object,categories:Object,videoModule:Object,memberCategories:Object},setup(a){const t=x({link:a.videoModule.link,title:a.videoModule.title,description:a.videoModule.description,category_id:a.videoModule.category_id,member_categories:a.videoModule.member_categories?a.videoModule.member_categories.map(s=>({name:s})):[]});return{form:t,submit:()=>{L.Inertia.put(`/admin/video-modules/${a.videoModule.id}`,{category_id:t.category_id,title:t.title,description:t.description,link:t.link,member_categories:t.member_categories},{onSuccess:()=>{D.fire({title:"Success!",text:"Materi /Modul Berhasil Diupdate!.",icon:"success",showConfirmButton:!1,timer:1e3})}})}}}},N={class:"page-wrapper"},E={class:"page-content"},H=C('<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3"><div class="breadcrumb-title pe-3">Video Pembelajaran</div><div class="ps-3"><nav aria-label="breadcrumb"><ol class="breadcrumb mb-0 p-0"><li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a></li><li class="breadcrumb-item active" aria-current="page">Edit Video Pembelajaran</li></ol></nav></div></div>',1),O={class:"card border-top border-0 border-3 border-primary"},T={class:"card-body"},A={class:"d-lg-flex align-items-center"},J={class:"ms-auto"},F={class:"col-12"},z=e("label",{class:"form-label"},"Kategori Peminatan",-1),I=e("option",{value:""},"[ Pilih ]",-1),q=["value"],G={key:0,class:"invalid-feedback"},Q={class:"col-12"},R=e("label",{class:"form-label"},"Kategori Member (Khusus Untuk Membership Bulanan, Kosongkan Jika Tidak Ada)",-1),W={class:"col-12"},X=e("label",{class:"form-label"},"Judul",-1),Y={key:0,class:"invalid-feedback"},Z={class:"col-12"},$=e("label",{class:"form-label"},"Deskripsi",-1),ee={key:0,class:"invalid-feedback"},te={class:"col-12"},ie=e("label",{class:"form-label"},"Link",-1),oe={key:0,class:"invalid-feedback"},se=e("div",{class:"col-12"},[e("button",{type:"submit",class:"btn btn-primary btn-sm px-5"},"Submit")],-1);function ae(a,t,o,s,le,re){const g=u("Head"),k=u("Link"),h=u("multiselect");return l(),r(f,null,[b(g,null,{default:v(()=>{var i;return[e("title",null,d((i=a.$page.props.setting.app_name)!=null?i:"Atur Setting Terlebih Dahulu")+" - Edit Video Pembelajaran",1)]}),_:1}),e("div",N,[e("div",E,[H,e("div",O,[e("div",T,[e("div",A,[e("div",J,[b(k,{href:"/admin/video-modules",class:"btn btn-primary btn-sm mt-2 mt-lg-0"},{default:v(()=>[B("Kembali")]),_:1})])]),e("form",{onSubmit:t[5]||(t[5]=w((...i)=>s.submit&&s.submit(...i),["prevent"])),class:"row g-3"},[e("div",F,[z,n(e("select",{"onUpdate:modelValue":t[0]||(t[0]=i=>s.form.category_id=i),class:c([{"is-invalid":o.errors.category_id},"form-select"])},[I,(l(!0),r(f,null,j(o.categories,(i,p)=>(l(),r("option",{key:p,value:i.id},d(i.name),9,q))),128))],2),[[S,s.form.category_id]]),o.errors.category_id?(l(),r("div",G,d(o.errors.category_id),1)):m("",!0)]),e("div",Q,[R,b(h,{modelValue:s.form.member_categories,"onUpdate:modelValue":t[1]||(t[1]=i=>s.form.member_categories=i),options:o.memberCategories,multiple:!0,label:"name","close-on-select":!0,"allow-empty":!0,"track-by":"name",placeholder:"[ Pilih ]"},null,8,["modelValue","options"])]),e("div",W,[X,n(e("input",{type:"text",class:c(["form-control",{"is-invalid":o.errors.title}]),"onUpdate:modelValue":t[2]||(t[2]=i=>s.form.title=i),placeholder:"Judul"},null,2),[[_,s.form.title]]),o.errors.title?(l(),r("div",Y,d(o.errors.title),1)):m("",!0)]),e("div",Z,[$,n(e("textarea",{cols:"30",rows:"10",class:c(["form-control",{"is-invalid":o.errors.description}]),"onUpdate:modelValue":t[3]||(t[3]=i=>s.form.description=i),placeholder:"Deskripsi Video"},null,2),[[_,s.form.description]]),o.errors.description?(l(),r("div",ee,d(o.errors.description),1)):m("",!0)]),e("div",te,[ie,n(e("input",{type:"text",class:c(["form-control",{"is-invalid":o.errors.link}]),"onUpdate:modelValue":t[4]||(t[4]=i=>s.form.link=i),placeholder:"Link"},null,2),[[_,s.form.link]]),o.errors.link?(l(),r("div",oe,d(o.errors.link),1)):m("",!0)]),se],32)])])])])],64)}const be=U(K,[["render",ae]]);export{be as default};