
function searchWord() {
    var parent=document.getElementById('searchBoxMobile');
    var filterspanid='search';
    var name='search';
    changeConditionMobile(filterspanid,name, parent);
}

function changeConditionMobile(filterspanid,name, parent) {

    loading = false;
    var temp = '';

    // CHECK FILTER TYPE NUMBER,LIST,RADIO
    if (parent.value === 'on')
    {
        if (parent.checked)
        {
            value = 1;
        }
        else
        {
            value = 0;
        }
    }
    else
    {
        if (parent.getAttribute('type')==='checkbox')
        {
            if (parent.checked)
            {
                value = parent.value;
            }
            else
            {
                value = 0;
                // REMOVE FROM FILTER BOX
                document.getElementById("filterBox" + name).remove();
            }
        }
        else
        {
            value = parent.value;
        }

    }
    // CHECK FILTER TYPE NUMBER,LIST,RADIO


    // CHECK ARRAY AND UPDATE
    var i = 0;

    // UPDATE CONDITION ARRAY
    condition.forEach(function (item)
    {
        if (item.key === name)
        {
            item.oldvalue = item.value;
            item.value = value;
            item.submit=0;
            i = 1;

            // name of filter box
            if (name!==name.replace('min',''))
            {
                document.getElementById("filterBox" + name).innerHTML = document.getElementById(filterspanid).innerText + ' از ' + $(parent).find('option:selected').text() + ' &nbsp; <i class="fas fa-times filter-title-remove-icon"></i>';
            }
            else if (name!==name.replace('max',''))
            {
                document.getElementById("filterBox" + name).innerHTML = document.getElementById(filterspanid).innerText + ' تا ' + $(parent).find('option:selected').text() + ' &nbsp; <i class="fas fa-times filter-title-remove-icon"></i>';
            }
            else if (name!==name.replace('filter',''))
            {
                document.getElementById("filterBox" + name).innerHTML = document.getElementById(filterspanid).innerText  + ' ' + $(parent).find('option:selected').text() + ' &nbsp; <i class="fas fa-times filter-title-remove-icon"></i>';
            }
            else if (name==='state')
            {
                document.getElementById("filterBox" + name).innerHTML = document.getElementById(filterspanid).innerText   +  ' ' +$("#state_mobile option:selected").html() + ' &nbsp; <i class="fas fa-times filter-title-remove-icon"></i>';
            }
            else if (name==='who')
            {
                document.getElementById("filterBox" + name).innerHTML = document.getElementById(filterspanid).innerText  +  ' ' +$("#who-mobile option:selected").html() + ' &nbsp; <i class="fas fa-times filter-title-remove-icon"></i>';
            }
            else if (name==='search')
            {
                document.getElementById("filterBox" + name).innerHTML = 'جستجو' + ' ' +  parent.value +  ' &nbsp; <i class="fas fa-times filter-title-remove-icon"></i>';
            }

        }
    });

    // IF NOT IN ARRAY CREATE NEW
    if (i === 0) {
        var object = {};
        object.key = name;
        object.value = value;
        object.submit = 0;
        object.id = parent.id;
        object.oldvalue = 0;
        condition.push(object);

        // CREATE FILTER BOX
        var filter = document.createElement('div');

        filter.classList.add('bg-divar');
        filter.classList.add('text-white');
        filter.classList.add('fa-num');
        filter.classList.add('mobile-btn');
        filter.classList.add('mobile-filter');

        filter.id = "filterBox" + name;
        // name of filter box

        if (name!==name.replace('min',''))
        {
            filter.innerHTML = document.getElementById(filterspanid).innerText+' از '+$(parent).find('option:selected').text() + ' &nbsp; <i class="fas fa-times filter-title-remove-icon"></i>';
        }
        else if (name!==name.replace('max',''))
        {
            filter.innerHTML = document.getElementById(filterspanid).innerText + ' تا ' + $(parent).find('option:selected').text() + ' &nbsp; <i class="fas fa-times filter-title-remove-icon"></i>';
        }
        else if (name!==name.replace('filter',''))
        {
            filter.innerHTML = document.getElementById(filterspanid).innerText  + ' ' + $(parent).find('option:selected').text() + ' &nbsp; <i class="fas fa-times filter-title-remove-icon"></i>';
        }
        else if (name==='state')
        {
            filter.innerHTML = document.getElementById(filterspanid).innerText + ' ' + $("#state_mobile option:selected").html() + ' &nbsp; <i class="fas fa-times filter-title-remove-icon"></i>';
        }
        else if (name==='who')
        {
            filter.innerHTML = document.getElementById(filterspanid).innerText + ' ' +$("#who-mobile option:selected").html() + ' &nbsp; <i class="fas fa-times filter-title-remove-icon"></i>';
        }
        else if (name==='search')
        {
            filter.innerHTML = 'جستجو' + ' ' +parent.value +  ' &nbsp; <i class="fas fa-times filter-title-remove-icon"></i>';
            saveConditionMobile();
        }
        else
        {
            filter.innerHTML = document.getElementById(filterspanid).innerText + '&nbsp;'  + '<i class="fas fa-times filter-title-remove-icon"></i>';
        }

        document.getElementById('filter_box_mobile').append(filter);

        // remove filter box --> <select option> and <radio>
        filter.onclick = function () {
            if (parent.checked)
                parent.checked=false;
            else
                parent.value='';


            // update condition array
            document.getElementById("filterBox" + name).remove();
            for (var j=0;j<condition.length;j++)
            {
                if (condition[j]['key']===name)
                    condition.splice(j,1);
            }
            if (condition.length>1)
            {
                document.getElementById('filter-mobile-span').innerText=(condition.length-1)+'  فیلتر ';
            }
            else
            {
                document.getElementById('filter-mobile-span').innerText='  فیلترها ';
                document.getElementById('filter-mobile-btn').style.background="inherit";
                document.getElementById('filter-mobile-i').style.color="inherit";
                document.getElementById('filter-mobile-span').style.color="inherit";
            }
            // load new data
            counter = 0;
            $(window).scrollTop(0);
            oldscroll=0;
            load_data();
        }

    }
    // IF NOT IN ARRAY CREATE NEW
    console.log(condition);
}

function openSubCategoryMobile(node_id,role) {

    resetParametr();
    $('#custom_mobile_id').html('');
    condition=[];

    document.getElementById('filter-mobile-span').innerText='  فیلترها ';
    document.getElementById('filter-mobile-btn').style.background="inherit";
    document.getElementById('filter-mobile-i').style.color="inherit";
    document.getElementById('filter-mobile-span').style.color="inherit";

    var object={};
    object.key='category';
    object.value=node_id;
    condition.push(object);

    if (role==='parent')
    {
        $.ajax({
            url:'/Api/Mobile/nodeList',
            method:'post',
            data:{id:node_id},
            dataType:'json',
            success:function (data) {
                if (data['id']!==null)
                {
                    $('#mobile_category_name').html(' <i class="fas fa-arrow-right"></i> '+data['name']);
                    document.getElementById('mobile_category_name').onclick=function () {
                        openSubCategoryMobile(data['id'],'parent')
                    };
                }
                else
                {
                    $('#mobile_category_name').html('دسته بندی ها');
                }

                if(data['category']!=='')
                {
                    $('#category_mobile').html(data['category']);
                }
                else
                {
                    $('#category_mobile').html('');
                }

                if (data['blog']!=='')
                {
                    $('#blog_view').html(data['blog']);
                }
                else
                {
                    $('#blog_view').html('');
                }
            }
        });
    }
    else
    {
        // CHANGE FILTER
        $.ajax({
            url:'/Api/Mobile/changeCategory',
            method:'post',
            data:{id:node_id},
            dataType:'json',
            success:function (data) {
                if(data['filter']!=='')
                {
                    $('#custom_mobile_id').html(data['filter']);
                }
                else
                {
                    $('#custom_mobile_id').html('');
                }
                $('#category-mobile-span').text(data['name']);
                $('#category-mobile-i').removeClass('fa fa-list').addClass('fas fa-times filter-title-remove-icon');
                $('#category-mobile-btn').attr('data-toggle','').attr('data-target','');

                document.getElementById('category-mobile-btn').style.background="#a62626";
                document.getElementById('category-mobile-i').style.color="#000000";
                document.getElementById('category-mobile-span').style.color="#ffffff";
            }
        });
        // CHANGE FILTER

        // LOAD DATA
        load_data();
        // LOAD DATA
    }
    loadSubCategoryName(node_id);
    // CHANGE NODE LIST
}

function openSubCategoryChangConditionMobile(node_id,role) {

    resetParametr();
    $('#custom_mobile_id').html('');
    condition=[];

    document.getElementById('filter-mobile-span').innerText='  فیلترها ';
    document.getElementById('filter-mobile-btn').style.background="inherit";
    document.getElementById('filter-mobile-i').style.color="inherit";
    document.getElementById('filter-mobile-span').style.color="inherit";

    var object={};
    object.key='category';
    object.value=node_id;
    condition.push(object);

    if (role==='parent')
    {
        $.ajax({
            url:'/Api/Mobile/nodeList',
            method:'post',
            data:{id:node_id},
            dataType:'json',
            success:function (data) {
                if (data['id']!==null)
                {
                    $('#mobile_category_name').html(' <i class="fas fa-arrow-right"></i> '+data['name']);
                    document.getElementById('mobile_category_name').onclick=function () {
                        openSubCategoryMobile(data['id'],'parent')
                    };
                }
                else
                {
                    $('#mobile_category_name').html('دسته بندی ها');
                }

                if(data['category']!=='')
                {
                    $('#category_mobile').html(data['category']);
                }
                else
                {
                    $('#category_mobile').html('');
                }

                if (data['blog']!=='')
                {
                    $('#blog_view').html(data['blog']);
                }
                else
                {
                    $('#blog_view').html('');
                }
            }
        });
    }
    else
    {
        // CHANGE FILTER
        $.ajax({
            url:'/Api/Mobile/changeCategory',
            method:'post',
            data:{id:node_id},
            dataType:'json',
            success:function (data) {
                if(data['filter']!=='')
                {
                    $('#custom_mobile_id').html(data['filter']);
                }
                else
                {
                    $('#custom_mobile_id').html('');
                }
                $('#category-mobile-span').text(data['name']);
                $('#category-mobile-i').removeClass('fa fa-list').addClass('fas fa-times filter-title-remove-icon');
                $('#category-mobile-btn').attr('data-toggle','').attr('data-target','');

                document.getElementById('category-mobile-btn').style.background="#a62626";
                document.getElementById('category-mobile-i').style.color="#000000";
                document.getElementById('category-mobile-span').style.color="#ffffff";
            }
        });
        // CHANGE FILTER

        // LOAD DATA
        load_data();
        // LOAD DATA
    }
    loadSubCategoryName(node_id);
    // CHANGE NODE LIST

    changeConditionMobile('statefilter','state',document.getElementById('state_mobile'));

    setTimeout(function () {
        saveConditionMobile();

    },500);
}

function deleteCategoryMobile() {

    if (condition.length>0)
    {
        condition=[];

        $('#category-mobile-span').text(' دسته بندی ها ');
        $('#category-mobile-i').removeClass('fas fa-times filter-title-remove-icon').addClass('fa fa-list');
        document.getElementById('category-mobile-btn').style.background="inherit";
        document.getElementById('category-mobile-i').style.color="inherit";
        document.getElementById('category-mobile-span').style.color="inherit";

        document.getElementById('filter-mobile-span').innerText='  فیلترها ';
        document.getElementById('filter-mobile-btn').style.background="inherit";
        document.getElementById('filter-mobile-i').style.color="inherit";
        document.getElementById('filter-mobile-span').style.color="inherit";


        // RESET ADVERTISMENT LIST , filter box, img and urgent and scroll bar
        resetParametr();
        $('#custom_mobile_id').html('');
        // RESET ADVERTISMENT LIST , filter box, img and urgent and scroll bar
        loadSubCategoryName(1);
        load_data();
    }
    else
    {
        $('#category-mobile-btn').attr('data-toggle','modal').attr('data-target','#modal_category');
    }

}

function deleteConditionMobile() {

    for (var j=0;j<condition.length;j++)
    {
        if (condition[j]['key']!=='category')
        {
            // CHECK IF SUBMIT EQUAL 0 REPLACE VALUE WITH OLD VALUE AND RELATED SETTING
            if (condition[j]['submit']===0)
            {
                var oldText=$('#'+condition[j]['id']).find('option:selected').text();
                condition[j]['value']=condition[j]['oldvalue'];
                condition[j]['oldvalue']=0;
                condition[j]['submit']=1;

                // IF VALUE 0 MEAN THIS ITEM SELECTED NOW
                if (condition[j]['value']===0)
                {
                    document.getElementById('filterBox'+condition[j]['key']).remove();

                    // CHECK LIST OR ON/OFF BTN
                    if (document.getElementById(condition[j]['id']).value==='on')
                    {
                        document.getElementById(condition[j]['id']).checked=false;
                    }
                    else
                    {
                        document.getElementById(condition[j]['id']).value='';
                    }
                    condition.splice(j,1);
                    j--;
                }
                else
                {
                    // CHECK LIST OR ON/OFF BTN
                    if (document.getElementById(condition[j]['id']).value==='on')
                    {
                        document.getElementById(condition[j]['id']).checked=true;
                    }
                    else
                    {
                        document.getElementById(condition[j]['id']).value=condition[j]['value'];
                        var newText=$('#'+condition[j]['id']).find('option:selected').text();
                        var temp=document.getElementById('filterBox'+condition[j]['key']).innerHTML;
                        document.getElementById('filterBox'+condition[j]['key']).innerHTML=temp.replace(oldText,newText);
                    }
                }
            }
        }
    }

    // load new data
    counter = 0;
    $(window).scrollTop(0);
    oldscroll=0;
    load_data();
    // load new data
}

function saveConditionMobile() {

    var count=0;
    for (var j=0;j<condition.length;j++)
    {
        if (condition[j]['key']!=='category')
        {
            // CHECK IF SUBMIT EQUAL 0 REPLACE VALUE WITH OLD VALUE AND RELATED SETTING
            if (condition[j]['submit']===0)
            {
                if (condition[j]['value']===0)
                {
                    document.getElementById('filterBox'+condition[j]['key']).remove();
                    condition.splice(j,1);
                    j--;
                    count--;
                }
                else
                {

                    condition[j]['submit']=1;
                }

            }
            count++;
        }

    }

    if (count>0)
    {
        document.getElementById('filter-mobile-span').innerText=count+'  فیلتر ';
        document.getElementById('filter-mobile-btn').style.background="#a62626";
        document.getElementById('filter-mobile-i').style.color="#ffffff";
        document.getElementById('filter-mobile-span').style.color="#ffffff";
    }
    else
    {
        document.getElementById('filter-mobile-span').innerText='  فیلترها ';
        document.getElementById('filter-mobile-btn').style.background="inherit";
        document.getElementById('filter-mobile-i').style.color="inherit";
        document.getElementById('filter-mobile-span').style.color="inherit";
    }


    // LOAD DATA AND RESET SCROLLBAR
    counter = 0;
    $(window).scrollTop(0);
    oldscroll=0;
    load_data();
    // LOAD DATA AND RESET SCROLLBAR
}

function suggestCategoryMobile(node_id) {

    var parent = document.getElementById('searchBoxMobile');

    resetParametr();

    condition=[];

    document.getElementById('filter-mobile-span').innerText='  فیلترها ';
    document.getElementById('filter-mobile-btn').style.background="inherit";
    document.getElementById('filter-mobile-i').style.color="inherit";
    document.getElementById('filter-mobile-span').style.color="inherit";

    var object={};
    object.key='category';
    object.value=node_id;
    condition.push(object);
    // RESET CONDITION

    // CHANGE FILTER
    $.ajax({
        url:'/Api/Mobile/changeCategory',
        method:'post',
        data:{id:node_id},
        dataType:'json',
        success:function (data) {
            if(data['filter']!=='')
            {
                $('#custom_mobile_id').html(data['filter']);
            }
            else
            {
                $('#custom_mobile_id').html('');
            }
            $('#category-mobile-span').text(data['name']);
            $('#category-mobile-i').removeClass('fa fa-list').addClass('fas fa-times filter-title-remove-icon');
            $('#category-mobile-btn').attr('data-toggle','').attr('data-target','');

            document.getElementById('category-mobile-btn').style.background="#a62626";
            document.getElementById('category-mobile-i').style.color="#000000";
            document.getElementById('category-mobile-span').style.color="#ffffff";
        }
    });
    // CHANGE FILTER

    changeConditionMobile('','search',parent);
    loadSubCategoryName(node_id);
}

function suggestMobile(type){
    var searchword=$('#searchBoxMobile').val();

    if(searchword.length > 2)
    {
        if(type==='suggest')
        {
            $.ajax({
                url:'/Api/Mobile/search',
                method:'post',
                data:{search:searchword},
                success:function (data) {
                    document.getElementById('suggestMobile').innerHTML=data;
                }
            });
        }
        else
        {
            document.getElementById('suggestMobile').innerHTML='';
            var parent=document.getElementById('searchBoxMobile');
            changeConditionMobile('','search',parent);
        }
    }

}


