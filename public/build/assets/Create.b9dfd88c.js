import{L as U}from"./Layout.5a89b8be.js";import{L as q,H as S,j as D,r as b,o as s,c as l,a as v,w as g,b as e,k as M,l as d,v as c,n as m,F as h,d as y,t as _,e as n,m as u,h as N,f as p,g as P}from"./app.c0360cc5.js";import{M as O}from"./vue3-multiselect.css_vue_type_style_index_0_src_true_lang.f1f60ea7.js";import{S as C}from"./sweetalert2.all.b68d34ed.js";import{E as K}from"./Editor.86d5edc6.js";import{a as k}from"./index.ec764b7d.js";import{_ as j}from"./_plugin-vue_export-helper.cdc0426e.js";const A={layout:U,components:{Link:q,Head:S,Editor:K,Multiselect:O},props:{errors:Object,categories:Object,memberCategories:Object},setup(){const r=D({category_id:"",lesson_category_id:"",title:"",description:"",exam_group_type:"",duration:"",random_question:"",random_answer:"",show_answer:"",show_question_number_navigation:"",show_question_number:"",next_question_automatically:"",show_prev_next_button:"",type_option:"",button_type_finish:"",repeat_the_exam:"",total_tolerance:"",assessment_type:"",minimal_grade_type:"",minimal_grade:"",description_grade_less_than_minimal:"",description_grade_more_than_minimal:"",certificate_print_user:"",exam_status:"",price_before_discount:"",price_after_discount:"",smallest_value_limit:"",biggest_value_limit:"",member_categories:"",sub_category_ids:[],lessonCategories:[],lessons:[],questionTitles:[],subCategories:[]});return{form:r,submit:()=>{N.Inertia.post("/admin/exam-groups",{category_id:r.category_id,lesson_category_id:r.lesson_category_id,title:r.title,description:r.description,exam_group_type:r.exam_group_type,duration:r.duration,random_question:r.random_question,random_answer:r.random_answer,show_answer:r.show_answer,show_question_number_navigation:r.show_question_number_navigation,show_question_number:r.show_question_number,next_question_automatically:r.next_question_automatically,show_prev_next_button:r.show_prev_next_button,type_option:r.type_option,button_type_finish:r.button_type_finish,repeat_the_exam:r.repeat_the_exam,total_tolerance:r.total_tolerance,smallest_value_limit:r.smallest_value_limit,biggest_value_limit:r.biggest_value_limit,assessment_type:r.assessment_type,minimal_grade_type:r.minimal_grade_type,minimal_grade:r.minimal_grade,description_grade_less_than_minimal:r.description_grade_less_than_minimal,description_grade_more_than_minimal:r.description_grade_more_than_minimal,certificate_print_user:r.certificate_print_user,member_categories:r.member_categories,exam_status:r.exam_status,price_before_discount:r.price_before_discount,price_after_discount:r.price_after_discount,sub_category_ids:r.sub_category_ids},{onSuccess:()=>{C.fire({title:"Success!",text:"Try Out Berhasil Disimpan!.",icon:"success",showConfirmButton:!1,timer:1e3})}})},lessonCategoryData:()=>{r.lesson_category_id="",r.lesson_id="",k.get(`/admin/categories/${r.category_id}/lesson-categories`).then(o=>{r.lessonCategories=o.data}).catch(o=>console.error(o)),k.get(`/admin/categories/${r.category_id}/sub-categories`).then(o=>{r.sub_category_ids=[],r.subCategories=o.data}).catch(o=>console.error(o))}}}},Y={class:"page-wrapper"},B={class:"page-content"},H=p('<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3"><div class="breadcrumb-title pe-3">Try Out</div><div class="ps-3"><nav aria-label="breadcrumb"><ol class="breadcrumb mb-0 p-0"><li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a></li><li class="breadcrumb-item active" aria-current="page">Tambah Try Out</li></ol></nav></div></div>',1),L={class:"card border-top border-0 border-3 border-primary"},J={class:"card-body"},E={class:"d-lg-flex align-items-center"},z={class:"ms-auto"},I={class:"col-12"},F=e("label",{class:"form-label"},"Kategori Peminatan",-1),W=e("option",{value:""},"[ Pilih ]",-1),G=["value"],Q={key:0,class:"invalid-feedback"},R={class:"col-12"},X=e("label",{class:"form-label"},"Sub Kategori Peminatan",-1),Z={class:"col-12"},$=e("label",{class:"form-label"},"Kategori Member (Khusus Untuk Membership Bulanan, Kosongkan Jika Tidak Ada)",-1),ee={class:"col-12"},oe=e("label",{class:"form-label"},"Kategori Mata Pelajaran",-1),ie=e("option",{value:""},"[ Pilih ]",-1),te=["value"],ae={key:0,class:"invalid-feedback"},se={class:"col-12"},le=e("label",{class:"form-label"},"Judul Try Out",-1),ne={key:0,class:"invalid-feedback"},re={class:"col-12"},_e=e("label",{class:"form-label"},"Deskripsi Try Out",-1),de={key:0},me={class:"col-12"},ce=e("label",{class:"form-label"},"Tipe Try Out",-1),ue=e("option",{value:""},"[ Pilih ]",-1),ve=e("option",{value:"1"},"Tiap Tes Digabung Dalam Satu Waktu",-1),be=e("option",{value:"2"},"Tiap Tes Memiliki Waktunya Masing-Masing",-1),he=[ue,ve,be],fe={key:0,class:"invalid-feedback"},ge={key:0,class:"col-12"},ye=e("label",{class:"form-label"},"Durasi Try Out (Menit)",-1),ke={key:0,class:"invalid-feedback"},pe={key:1,class:"col-12"},xe=e("label",{class:"form-label"},"Soal Acak",-1),we=e("option",{value:""},"[ Pilih ]",-1),Te=e("option",{value:"1"},"Ya",-1),Ve=e("option",{value:"0"},"Tidak",-1),Ue=[we,Te,Ve],qe={key:0,class:"invalid-feedback"},Se={key:2,class:"col-12"},De=e("label",{class:"form-label"},"Jawaban Acak",-1),Me=e("option",{value:""},"[ Pilih ]",-1),Ne=e("option",{value:"1"},"Ya",-1),Pe=e("option",{value:"0"},"Tidak",-1),Oe=[Me,Ne,Pe],Ce={key:0,class:"invalid-feedback"},Ke={key:3,class:"col-12"},je=e("label",{class:"form-label"},"Tampilkan Jawaban",-1),Ae=e("option",{value:""},"[ Pilih ]",-1),Ye=e("option",{value:"1"},"Ya",-1),Be=e("option",{value:"0"},"Tidak",-1),He=[Ae,Ye,Be],Le={key:0,class:"invalid-feedback"},Je={key:4,class:"col-12"},Ee=e("label",{class:"form-label"},"Tampilkan Navigasi Nomor Soal",-1),ze=e("option",{value:""},"[ Pilih ]",-1),Ie=e("option",{value:"1"},"Ya",-1),Fe=e("option",{value:"0"},"Tidak",-1),We=[ze,Ie,Fe],Ge={key:0,class:"invalid-feedback"},Qe={key:5,class:"col-12"},Re=e("label",{class:"form-label"},"Tampilkan Nomor Soal",-1),Xe=e("option",{value:""},"[ Pilih ]",-1),Ze=e("option",{value:"1"},"Ya",-1),$e=e("option",{value:"0"},"Tidak",-1),eo=[Xe,Ze,$e],oo={key:0,class:"invalid-feedback"},io={key:6,class:"col-12"},to=e("label",{class:"form-label"},"Pertanyaan Selanjutnya Secara Otomatis",-1),ao=e("option",{value:""},"[ Pilih ]",-1),so=e("option",{value:"1"},"Ya",-1),lo=e("option",{value:"0"},"Tidak",-1),no=[ao,so,lo],ro={key:0,class:"invalid-feedback"},_o={key:7,class:"col-12"},mo=e("label",{class:"form-label"},"Tampilkan Button Sebelum & Selanjutnya",-1),co=e("option",{value:""},"[ Pilih ]",-1),uo=e("option",{value:"1"},"Ya",-1),vo=e("option",{value:"0"},"Tidak",-1),bo=[co,uo,vo],ho={key:0,class:"invalid-feedback"},fo={key:8,class:"col-12"},go=e("label",{class:"form-label"},"Tipe Pilihan Ganda",-1),yo=e("option",{value:""},"[ Pilih ]",-1),ko=e("option",{value:"1"},"Button Option dan Soal Menyatu (Normal)",-1),po=e("option",{value:"2"},"Button Option ke Samping dan jawaban menyatu dengan soal",-1),xo=[yo,ko,po],wo={key:0,class:"invalid-feedback"},To={key:9,class:"col-12"},Vo=e("label",{class:"form-label"},"Tampilan Button Akhiri Ujian / Sesi Selanjutnya",-1),Uo=e("option",{value:""},"[ Pilih ]",-1),qo=e("option",{value:"1"},"Ditampilkan Pada Setiap Soal",-1),So=e("option",{value:"2"},"Hanya Ditampilkan Pada Soal Terakhir",-1),Do=[Uo,qo,So],Mo={key:0,class:"invalid-feedback"},No={key:10,class:"col-12"},Po=e("label",{class:"form-label"},"Siswa Dapat Mengulangi Try Out",-1),Oo=e("option",{value:""},"[ Pilih ]",-1),Co=e("option",{value:"0"},"Tidak",-1),Ko=e("option",{value:"1"},"Ya",-1),jo=[Oo,Co,Ko],Ao={key:0,class:"invalid-feedback"},Yo={class:"col-12"},Bo=e("label",{class:"form-label"},"Jenis Penilaian",-1),Ho=p('<option value="">[ Pilih ]</option><option value="1">Nilai pada tiap tes dijumlahkan</option><option value="2">Persentase dari masing-masing tes</option><option value="3">Nilai rata-rata dari masing-masing tes</option><option value="4">Nilai pada tiap kategori tes dijumlahkan</option>',5),Lo=[Ho],Jo={key:0,class:"invalid-feedback"},Eo={class:"col-12"},zo=e("label",{class:"form-label"},"Tipe Nilai Minimal",-1),Io=e("option",{value:""},"[ Pilih ]",-1),Fo=e("option",{value:"0"},"Tidak Ada Nilai Minimal",-1),Wo=e("option",{value:"1"},"Nilai Minimal Di Ambil Dari Ambang Batas Tiap Tes",-1),Go=e("option",{value:"2"},"Nilai Minimal Ditentukan Untuk Keseluruhan Tes",-1),Qo=[Io,Fo,Wo,Go],Ro={key:0,class:"invalid-feedback"},Xo={key:11,class:"col-12"},Zo=e("label",{class:"form-label"},"Nilai Minimal Lulus",-1),$o={key:0,class:"invalid-feedback"},ei={key:12,class:"col-12"},oi=e("label",{class:"form-label"},"Keterangan Nilai Kurang Dari Nilai Minimal",-1),ii={key:0,class:"invalid-feedback"},ti={key:13,class:"col-12"},ai=e("label",{class:"form-label"},"Keterangan Nilai Lebih Dari Nilai Minimal",-1),si={key:0,class:"invalid-feedback"},li={class:"col-12"},ni=e("label",{class:"form-label"},"Nilai Minimal Yang Ditampilkan (Kosongkan Jika Tidak Ada)",-1),ri={key:0,class:"invalid-feedback"},_i={class:"col-12"},di=e("label",{class:"form-label"},"Nilai Maksimal Yang Ditampilkan (Kosongkan Jika Tidak Ada)",-1),mi={key:0,class:"invalid-feedback"},ci={class:"col-12"},ui=e("label",{class:"form-label"},"Izinkan Siswa Mencetak Hasil Ujian",-1),vi=e("option",{value:""},"[ Pilih ]",-1),bi=e("option",{value:"0"},"Tidak",-1),hi=e("option",{value:"1"},"Ya",-1),fi=[vi,bi,hi],gi={key:0,class:"invalid-feedback"},yi={key:14,class:"col-12"},ki=e("label",{class:"form-label"},"Maksimal Toleransi Keluar Tes (Kosongkan Jika Tidak Ada)",-1),pi={key:0,class:"invalid-feedback"},xi={class:"col-12"},wi=e("label",{class:"form-label"},"Harga TryOut (Sebelum Diskon)",-1),Ti={key:0,class:"invalid-feedback"},Vi={class:"col-12"},Ui=e("label",{class:"form-label"},"Harga TryOut (Sesudah Diskon)",-1),qi={key:0,class:"invalid-feedback"},Si={class:"col-12"},Di=e("label",{class:"form-label"},"Status Try Out",-1),Mi=e("option",{value:""},"[ Pilih ]",-1),Ni=e("option",{value:"active"},"Aktive",-1),Pi=e("option",{value:"inactive"},"Inactive",-1),Oi=e("option",{value:"inprogress"},"Inprogress",-1),Ci=[Mi,Ni,Pi,Oi],Ki={key:0,class:"invalid-feedback"},ji=e("div",{class:"col-12"},[e("button",{type:"submit",class:"btn btn-primary btn-sm px-5"},"Submit")],-1);function Ai(r,a,i,o,Yi,Bi){const x=b("Head"),w=b("Link"),f=b("multiselect"),T=b("Editor");return s(),l(h,null,[v(x,null,{default:g(()=>{var t;return[e("title",null,_((t=r.$page.props.setting.app_name)!=null?t:"Atur Setting Terlebih Dahulu")+" - Tambah Try Out",1)]}),_:1}),e("div",Y,[e("div",B,[H,e("div",L,[e("div",J,[e("div",E,[e("div",z,[v(w,{href:"/admin/exam-groups",class:"btn btn-primary btn-sm mt-2 mt-lg-0"},{default:g(()=>[P("Kembali")]),_:1})])]),e("form",{onSubmit:a[32]||(a[32]=M((...t)=>o.submit&&o.submit(...t),["prevent"])),class:"row g-3"},[e("div",I,[F,d(e("select",{onChange:a[0]||(a[0]=(...t)=>o.lessonCategoryData&&o.lessonCategoryData(...t)),"onUpdate:modelValue":a[1]||(a[1]=t=>o.form.category_id=t),class:m([{"is-invalid":i.errors.category_id},"form-select"])},[W,(s(!0),l(h,null,y(i.categories,(t,V)=>(s(),l("option",{key:V,value:t.id},_(t.name),9,G))),128))],34),[[c,o.form.category_id]]),i.errors.category_id?(s(),l("div",Q,_(i.errors.category_id),1)):n("",!0)]),e("div",R,[X,v(f,{modelValue:o.form.sub_category_ids,"onUpdate:modelValue":a[2]||(a[2]=t=>o.form.sub_category_ids=t),options:o.form.subCategories,multiple:!0,label:"name","close-on-select":!0,"allow-empty":!0,"track-by":"id",placeholder:"[ Pilih ]"},null,8,["modelValue","options"])]),e("div",Z,[$,v(f,{modelValue:o.form.member_categories,"onUpdate:modelValue":a[3]||(a[3]=t=>o.form.member_categories=t),options:i.memberCategories,multiple:!0,label:"name","close-on-select":!0,"allow-empty":!0,"track-by":"name",placeholder:"[ Pilih ]"},null,8,["modelValue","options"])]),e("div",ee,[oe,d(e("select",{onChange:a[4]||(a[4]=(...t)=>r.lessonData&&r.lessonData(...t)),"onUpdate:modelValue":a[5]||(a[5]=t=>o.form.lesson_category_id=t),class:m([{"is-invalid":i.errors.lesson_category_id},"form-select"])},[ie,(s(!0),l(h,null,y(o.form.lessonCategories,t=>(s(),l("option",{value:t.id},_(t.name),9,te))),256))],34),[[c,o.form.lesson_category_id]]),i.errors.lesson_category_id?(s(),l("div",ae,_(i.errors.lesson_category_id),1)):n("",!0)]),e("div",se,[le,d(e("input",{type:"text",class:m(["form-control",{"is-invalid":i.errors.title}]),"onUpdate:modelValue":a[6]||(a[6]=t=>o.form.title=t),placeholder:"Nama"},null,2),[[u,o.form.title]]),i.errors.title?(s(),l("div",ne,_(i.errors.title),1)):n("",!0)]),e("div",re,[_e,v(T,{"api-key":"ks7buom19yw30zn9i2t0x36p1j5yn8mch71i5ek9fz9xpivd",modelValue:o.form.description,"onUpdate:modelValue":a[7]||(a[7]=t=>o.form.description=t),init:{images_upload_url:"/upload",automatic_uploads:!0,height:400,plugins:["advlist autolink lists link image charmap print preview hr anchor pagebreak","searchreplace wordcount visualblocks visualchars code fullscreen","insertdatetime media nonbreaking save table contextmenu directionality","emoticons template paste textcolor colorpicker textpattern imagetools"],toolbar:"insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | print preview media | forecolor backcolor emoticons",image_advtab:!0}},null,8,["modelValue"]),i.errors.description?(s(),l("div",de,_(i.errors.description),1)):n("",!0)]),e("div",me,[ce,d(e("select",{"onUpdate:modelValue":a[8]||(a[8]=t=>o.form.exam_group_type=t),class:m([{"is-invalid":i.errors.exam_group_type},"form-select"])},he,2),[[c,o.form.exam_group_type]]),i.errors.exam_group_type?(s(),l("div",fe,_(i.errors.exam_group_type),1)):n("",!0)]),o.form.exam_group_type==1?(s(),l("div",ge,[ye,d(e("input",{type:"number",class:m(["form-control",{"is-invalid":i.errors.duration}]),"onUpdate:modelValue":a[9]||(a[9]=t=>o.form.duration=t),placeholder:"Durasi"},null,2),[[u,o.form.duration]]),i.errors.duration?(s(),l("div",ke,_(i.errors.duration),1)):n("",!0)])):n("",!0),o.form.exam_group_type==1?(s(),l("div",pe,[xe,d(e("select",{"onUpdate:modelValue":a[10]||(a[10]=t=>o.form.random_question=t),class:m([{"is-invalid":i.errors.random_question},"form-select"])},Ue,2),[[c,o.form.random_question]]),i.errors.random_question?(s(),l("div",qe,_(i.errors.random_question),1)):n("",!0)])):n("",!0),o.form.exam_group_type==1?(s(),l("div",Se,[De,d(e("select",{"onUpdate:modelValue":a[11]||(a[11]=t=>o.form.random_answer=t),class:m([{"is-invalid":i.errors.random_answer},"form-select"])},Oe,2),[[c,o.form.random_answer]]),i.errors.random_answer?(s(),l("div",Ce,_(i.errors.random_answer),1)):n("",!0)])):n("",!0),o.form.exam_group_type==1?(s(),l("div",Ke,[je,d(e("select",{"onUpdate:modelValue":a[12]||(a[12]=t=>o.form.show_answer=t),class:m([{"is-invalid":i.errors.show_answer},"form-select"])},He,2),[[c,o.form.show_answer]]),i.errors.show_answer?(s(),l("div",Le,_(i.errors.show_answer),1)):n("",!0)])):n("",!0),o.form.exam_group_type==1?(s(),l("div",Je,[Ee,d(e("select",{"onUpdate:modelValue":a[13]||(a[13]=t=>o.form.show_question_number_navigation=t),class:m([{"is-invalid":i.errors.show_question_number_navigation},"form-select"])},We,2),[[c,o.form.show_question_number_navigation]]),i.errors.show_question_number_navigation?(s(),l("div",Ge,_(i.errors.show_question_number_navigation),1)):n("",!0)])):n("",!0),o.form.exam_group_type==1?(s(),l("div",Qe,[Re,d(e("select",{"onUpdate:modelValue":a[14]||(a[14]=t=>o.form.show_question_number=t),class:m([{"is-invalid":i.errors.show_question_number},"form-select"])},eo,2),[[c,o.form.show_question_number]]),i.errors.show_question_number?(s(),l("div",oo,_(i.errors.show_question_number),1)):n("",!0)])):n("",!0),o.form.exam_group_type==1?(s(),l("div",io,[to,d(e("select",{"onUpdate:modelValue":a[15]||(a[15]=t=>o.form.next_question_automatically=t),class:m([{"is-invalid":i.errors.next_question_automatically},"form-select"])},no,2),[[c,o.form.next_question_automatically]]),i.errors.next_question_automatically?(s(),l("div",ro,_(i.errors.next_question_automatically),1)):n("",!0)])):n("",!0),o.form.exam_group_type==1?(s(),l("div",_o,[mo,d(e("select",{"onUpdate:modelValue":a[16]||(a[16]=t=>o.form.show_prev_next_button=t),class:m([{"is-invalid":i.errors.show_prev_next_button},"form-select"])},bo,2),[[c,o.form.show_prev_next_button]]),i.errors.show_prev_next_button?(s(),l("div",ho,_(i.errors.show_prev_next_button),1)):n("",!0)])):n("",!0),o.form.exam_group_type==1?(s(),l("div",fo,[go,d(e("select",{"onUpdate:modelValue":a[17]||(a[17]=t=>o.form.type_option=t),class:m([{"is-invalid":i.errors.type_option},"form-select"])},xo,2),[[c,o.form.type_option]]),i.errors.type_option?(s(),l("div",wo,_(i.errors.type_option),1)):n("",!0)])):n("",!0),o.form.exam_group_type==1?(s(),l("div",To,[Vo,d(e("select",{"onUpdate:modelValue":a[18]||(a[18]=t=>o.form.button_type_finish=t),class:m([{"is-invalid":i.errors.button_type_finish},"form-select"])},Do,2),[[c,o.form.button_type_finish]]),i.errors.button_type_finish?(s(),l("div",Mo,_(i.errors.button_type_finish),1)):n("",!0)])):n("",!0),o.form.exam_group_type==1?(s(),l("div",No,[Po,d(e("select",{"onUpdate:modelValue":a[19]||(a[19]=t=>o.form.repeat_the_exam=t),class:m([{"is-invalid":i.errors.repeat_the_exam},"form-select"])},jo,2),[[c,o.form.repeat_the_exam]]),i.errors.repeat_the_exam?(s(),l("div",Ao,_(i.errors.repeat_the_exam),1)):n("",!0)])):n("",!0),e("div",Yo,[Bo,d(e("select",{"onUpdate:modelValue":a[20]||(a[20]=t=>o.form.assessment_type=t),class:m([{"is-invalid":i.errors.assessment_type},"form-select"])},Lo,2),[[c,o.form.assessment_type]]),i.errors.assessment_type?(s(),l("div",Jo,_(i.errors.assessment_type),1)):n("",!0)]),e("div",Eo,[zo,d(e("select",{"onUpdate:modelValue":a[21]||(a[21]=t=>o.form.minimal_grade_type=t),class:m([{"is-invalid":i.errors.minimal_grade_type},"form-select"])},Qo,2),[[c,o.form.minimal_grade_type]]),i.errors.minimal_grade_type?(s(),l("div",Ro,_(i.errors.minimal_grade_type),1)):n("",!0)]),o.form.minimal_grade_type==2?(s(),l("div",Xo,[Zo,d(e("input",{type:"text",class:m(["form-control",{"is-invalid":i.errors.minimal_grade}]),"onUpdate:modelValue":a[22]||(a[22]=t=>o.form.minimal_grade=t),placeholder:"Nilai Minimal Lulus"},null,2),[[u,o.form.minimal_grade]]),i.errors.minimal_grade?(s(),l("div",$o,_(i.errors.minimal_grade),1)):n("",!0)])):n("",!0),o.form.minimal_grade_type==1||o.form.minimal_grade_type==2?(s(),l("div",ei,[oi,d(e("input",{type:"text",class:m(["form-control",{"is-invalid":i.errors.description_grade_less_than_minimal}]),"onUpdate:modelValue":a[23]||(a[23]=t=>o.form.description_grade_less_than_minimal=t),placeholder:"Keterangan Nilai < Nilai Minimal"},null,2),[[u,o.form.description_grade_less_than_minimal]]),i.errors.description_grade_less_than_minimal?(s(),l("div",ii,_(i.errors.description_grade_less_than_minimal),1)):n("",!0)])):n("",!0),o.form.minimal_grade_type==1||o.form.minimal_grade_type==2?(s(),l("div",ti,[ai,d(e("input",{type:"text",class:m(["form-control",{"is-invalid":i.errors.description_grade_more_than_minimal}]),"onUpdate:modelValue":a[24]||(a[24]=t=>o.form.description_grade_more_than_minimal=t),placeholder:"Keterangan Nilai > Nilai Minimal"},null,2),[[u,o.form.description_grade_more_than_minimal]]),i.errors.description_grade_more_than_minimal?(s(),l("div",si,_(i.errors.description_grade_more_than_minimal),1)):n("",!0)])):n("",!0),e("div",li,[ni,d(e("input",{type:"number",class:m(["form-control",{"is-invalid":i.errors.smallest_value_limit}]),"onUpdate:modelValue":a[25]||(a[25]=t=>o.form.smallest_value_limit=t),placeholder:"Nilai Minimal Yang Ditampilkan"},null,2),[[u,o.form.smallest_value_limit]]),i.errors.smallest_value_limit?(s(),l("div",ri,_(i.errors.smallest_value_limit),1)):n("",!0)]),e("div",_i,[di,d(e("input",{type:"number",class:m(["form-control",{"is-invalid":i.errors.biggest_value_limit}]),"onUpdate:modelValue":a[26]||(a[26]=t=>o.form.biggest_value_limit=t),placeholder:"Nilai Maksimal Yang Ditampilkan"},null,2),[[u,o.form.biggest_value_limit]]),i.errors.biggest_value_limit?(s(),l("div",mi,_(i.errors.biggest_value_limit),1)):n("",!0)]),e("div",ci,[ui,d(e("select",{"onUpdate:modelValue":a[27]||(a[27]=t=>o.form.certificate_print_user=t),class:m([{"is-invalid":i.errors.certificate_print_user},"form-select"])},fi,2),[[c,o.form.certificate_print_user]]),i.errors.certificate_print_user?(s(),l("div",gi,_(i.errors.certificate_print_user),1)):n("",!0)]),o.form.exam_group_type==1?(s(),l("div",yi,[ki,d(e("input",{type:"number",class:m(["form-control",{"is-invalid":i.errors.total_tolerance}]),"onUpdate:modelValue":a[28]||(a[28]=t=>o.form.total_tolerance=t),placeholder:"Maksimal Toleransi Keluar Tes"},null,2),[[u,o.form.total_tolerance]]),i.errors.total_tolerance?(s(),l("div",pi,_(i.errors.total_tolerance),1)):n("",!0)])):n("",!0),e("div",xi,[wi,d(e("input",{type:"number",class:m(["form-control",{"is-invalid":i.errors.price_before_discount}]),"onUpdate:modelValue":a[29]||(a[29]=t=>o.form.price_before_discount=t),placeholder:"Harga TryOut (Sebelum Diskon)",min:"0"},null,2),[[u,o.form.price_before_discount]]),i.errors.price_before_discount?(s(),l("div",Ti,_(i.errors.price_before_discount),1)):n("",!0)]),e("div",Vi,[Ui,d(e("input",{type:"number",class:m(["form-control",{"is-invalid":i.errors.price_after_discount}]),"onUpdate:modelValue":a[30]||(a[30]=t=>o.form.price_after_discount=t),placeholder:"Harga TryOut (Sesudah Diskon)",min:"0"},null,2),[[u,o.form.price_after_discount]]),i.errors.price_after_discount?(s(),l("div",qi,_(i.errors.price_after_discount),1)):n("",!0)]),e("div",Si,[Di,d(e("select",{"onUpdate:modelValue":a[31]||(a[31]=t=>o.form.exam_status=t),class:m([{"is-invalid":i.errors.exam_status},"form-select"])},Ci,2),[[c,o.form.exam_status]]),i.errors.exam_status?(s(),l("div",Ki,_(i.errors.exam_status),1)):n("",!0)]),ji],32)])])])])],64)}const Wi=j(A,[["render",Ai]]);export{Wi as default};