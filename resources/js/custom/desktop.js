
function search() {
    var parent=document.getElementById('searchBox');
    var filterspanid='search';
    var name='search';
    changeCondition(filterspanid,name, parent);
}

//  CHANGE CONDITION SAVE TO ARRAY
function changeCondition(filterspanid,name, parent) {

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
            // REMOVE FROM FILTER BOX
            document.getElementById("filterBox" + name).remove();
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
    condition.forEach(function (item) {
        if (item.key === name) {
            item.value = value;
            i = 1;
            // name of filter box

            if (name!==name.replace('min',''))
            {
                document.getElementById("filterBox" + name).innerHTML = document.getElementById(filterspanid).innerText + ' از ' + $(parent).find('option:selected').text() + ' &nbsp; <i class="fas fa-times text-white"></i>';
            }
            else if (name!==name.replace('max',''))
            {
                document.getElementById("filterBox" + name).innerHTML = document.getElementById(filterspanid).innerText + ' تا ' + $(parent).find('option:selected').text() + ' &nbsp; <i class="fas fa-times text-white"></i>';
            }
            else if (name!==name.replace('filter',''))
            {
                document.getElementById("filterBox" + name).innerHTML = document.getElementById(filterspanid).innerText  + ' ' + $(parent).find('option:selected').text() + ' &nbsp; <i class="fas fa-times text-white"></i>';
            }
            else if (name==='state')
            {
                document.getElementById("filterBox" + name).innerHTML = document.getElementById(filterspanid).innerText   +  ' ' +$("#state option:selected").html() + ' &nbsp; <i class="fas fa-times text-white"></i>';
            }
            else if (name==='who')
            {
                document.getElementById("filterBox" + name).innerHTML = document.getElementById(filterspanid).innerText  +  ' ' +$("#who option:selected").html() + ' &nbsp; <i class="fas fa-times text-white"></i>';
            }
            else if (name==='search')
            {
                document.getElementById("filterBox" + name).innerHTML = 'جستجو ' + ' ' + parent.value +  ' &nbsp; <i class="fas fa-times text-white"></i>';
            }

        }

    });

    // DELETE FROM ARRAY IF CLICK --> RADIO CLICK NO FILTER BOX CLICK
    if (value===0)
    {
        for (var j=0;j<condition.length;j++)
        {
            if (condition[j]['key']===name)
                condition.splice(j,1);
        }
    }
    // DELETE FROM ARRAY IF CLICK --> RADIO CLICK NO FILTER BOX CLICK

    // CHECK ARRAY AND UPDATE

    // IF NOT IN ARRAY CREATE NEW
    if (i === 0) {
        var object = {};
        object.key = name;
        object.value = value;
        condition.push(object);

        // CREATE FILTER BOX
        var filter = document.createElement('div');

        filter.classList.add('d-inline-block');
        filter.classList.add('bg-danger');
        filter.classList.add('text-white');
        filter.classList.add('text-center');
        filter.classList.add('fa-num');
        filter.classList.add('p-1');
        filter.classList.add('mt-1');
        filter.classList.add('font-size-12');
        filter.style.borderRadius = '13px';
        filter.style.cursor = 'pointer';
        filter.id = "filterBox" + name;
        // name of filter box

        if (name!==name.replace('min',''))
        {
            filter.innerHTML = document.getElementById(filterspanid).innerText+' از '+$(parent).find('option:selected').text() + ' &nbsp; <i class="fas fa-times text-white"></i>';
        }
        else if (name!==name.replace('max',''))
        {
            filter.innerHTML = document.getElementById(filterspanid).innerText + ' تا ' + $(parent).find('option:selected').text() + ' &nbsp; <i class="fas fa-times text-white"></i>';
        }
        else if (name!==name.replace('filter',''))
        {
            filter.innerHTML = document.getElementById(filterspanid).innerText  + ' ' + $(parent).find('option:selected').text() + ' &nbsp; <i class="fas fa-times text-white"></i>';
        }
        else if (name==='state')
        {
            filter.innerHTML = document.getElementById(filterspanid).innerText + ' ' + $("#state option:selected").html() + ' &nbsp; <i class="fas fa-times text-white"></i>';

        }
        else if (name==='who')
        {
            filter.innerHTML = document.getElementById(filterspanid).innerText + ' ' +$("#who option:selected").html() + ' &nbsp; <i class="fas fa-times text-white"></i>';
        }
        else if (name==='search')
        {
            filter.innerHTML = 'جستجو' + ' ' +parent.value +  ' &nbsp; <i class="fas fa-times text-white"></i>';

        }
        else
        {
            filter.innerHTML = document.getElementById(filterspanid).innerText + '&nbsp;'  + '<i class="fas fa-times text-white"></i>';
        }

        document.getElementById('filterBox').append(filter);

        // remove filter box --> <select option> and <radio>
        filter.onclick = function () {
            if (parent.checked)
                parent.checked=false;
            else
                parent.value='';


            // updatae condition array
            document.getElementById("filterBox" + name).remove();
            for (var j=0;j<condition.length;j++)
            {
                if (condition[j]['key']===name)
                    condition.splice(j,1);
            }
            // load new data
            counter = 0;
            $(window).scrollTop(0);
            load_data();
        }

    }
    // IF NOT IN ARRAY CREATE NEW

    // LOAD DATA AND RESET SCROLLBAR
    counter = 0;
    $(window).scrollTop(0);
    oldscroll=0;
    load_data();
    // LOAD DATA AND RESET SCROLLBAR
}

// CHANGE CATEGORY TO CHANGE CUSTOM FILTER
function openSubCategory(node_id,role){

    // RESET ADVERTISMENT LIST , filter box, img and urgent and scroll bar
    resetParametr();

    condition = [];
    var object = {};
    object.key = 'category';
    object.value = node_id;
    condition.push(object);

    // CHANGE NODE LIST
    if (role === 'parent')
    {
        $.ajax({
            url:'/Api/Desktop/nodeList',
            method:'post',
            data:{id:node_id},
            dataType:'json',
            success:function (data) {

                if(data['category']!=='')
                {
                    $('#category_descktop').html(data['category']);


                }
                else
                {
                    $('#category_descktop').html('');
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
        $('.selected').removeClass('border-danger selected');
        $(role).addClass('selected border-danger');
    }

    // CHANGE FILTER
    $.ajax({
        url:'/Api/Desktop/changeCategory',
        method:'post',
        data:{id:node_id},
        success:function (data) {
            if(data!=='')
            {
                $('#custom_id').html(data);
            }
            else
            {
                $('#custom_id').html('');
            }
        }
    });

    // LOAD DATA
    load_data();

    loadSubCategoryName(node_id);
}

// CHANGE CATEGORY TO CHANGE CUSTOM FILTER WHEN BACK FROM SHOW ADVERTISMENT
function openSubCategoryChangCondition(node_id,role){

    // RESET ADVERTISMENT LIST , filter box, img and urgent and scroll bar
    resetParametr();

    condition = [];
    var object = {};
    object.key = 'category';
    object.value = node_id;
    condition.push(object);




    setTimeout(function ()
    {
        // CHANGE NODE LIST
        if (role === 'parent')
        {
            $.ajax({
                url:'/Api/Desktop/nodeList',
                method:'post',
                data:{id:node_id},
                dataType:'json',
                success:function (data) {

                    if(data['category']!=='')
                    {
                        $('#category_descktop').html(data['category']);
                    }
                    else
                    {
                        $('#category_descktop').html('');
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
            $('.selected').removeClass('border-danger selected');
            $(role).addClass('selected border-danger');
        }

        // CHANGE FILTER
        $.ajax({
            url:'/Api/Desktop/changeCategory',
            method:'post',
            data:{id:node_id},
            success:function (data) {
                if(data!=='')
                {
                    $('#custom_id').html(data);
                }
                else
                {
                    $('#custom_id').html('');
                }
            }
        });

        changeCondition('statefilter','state',document.getElementById('state'));

        loadSubCategoryName(node_id);
    },500);





}

// SEARCH BOX
function suggestCategory(node_id) {

    var parent = document.getElementById('searchBox');

    $.ajax({
        url: '/Api/Desktop/nodeListSuggest',
        method: 'post',
        data: {id: node_id},
        success: function (data) {
            if (data !== '') {
                $('#category_descktop').html(data);
            } else {
                $('#category_descktop').html('');
            }
        }
    });


    // RESET ADVERTISMENT LIST , filter box, img and urgent and scroll bar
    resetParametr();
    // RESET ADVERTISMENT LIST , filter box, img and urgent and scroll bar

    condition=[];
    var object={};
    object.key='category';
    object.value=node_id;
    condition.push(object);

    $('#drowp-down-search').css("display", "none");
    loadSubCategoryName(node_id);

    if (parent.value!=='')
        changeCondition('','search',parent);
    else
    {
        load_data();
        resetParametr();
    }

}

function showCategoryList() {
    $('#drowp-down-search').toggle();
}

function hoverSuggest(node_id) {

    $('#hover-suggest').css("display", "block");

    $.ajax({
        url:'/Api/Desktop/hoverSuggest',
        method:'post',
        data:{id:node_id},
        success:function (data) {
            if(data!=='')
            {
                $('#hover-suggest').html(data);
            }
            else
            {
                $('#hover-suggest').html('');
            }
        }
    })
}

function suggest(type) {
    var searchword=$('#searchBox').val();

    if(searchword.length > 2)
    {
        if(type==='suggest')
        {
            $.ajax({
                url:'/Api/Desktop/search',
                method:'post',
                data:{search:searchword},
                success:function (data) {
                    document.getElementById('suggest').innerHTML=data;
                }
            });
        }
        else
        {
            document.getElementById('suggest').innerHTML='';
            var parent=document.getElementById('searchBox');
            changeCondition('','search',parent);
        }
    }

}
