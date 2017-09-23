jQuery.fn.moustache = function(data) {
  //console.info('invoking moustache template with data: '+JSON.stringify(data));
  var output = Mustache.render($(this).html(),data);
  //console.info('produces: '+output);
  this.empty().append(output);
};

jQuery(document).ready(function() {
  jQuery.ajaxSetup({
    error: function(jqXHR, textStatus) {
      console.error('Ajax failure: '+jqXHR.status+' '+textStatus);
    }
  });
});

var $od = new OpenData();
function OpenData() {
  this.DEFAULT_CAT = 'culture-leisure-and-heritage';
  this.init_api_url = function(category_name,subcategory_name,article) {
    console.info('init_api_url: '+category_name+','+subcategory_name+','+article);
    var fieldValue = '';
    if (article != undefined) fieldValue  = encodeURI(article);

    if(subcategory_name == 'active-locations') {
      var fieldToSearch =  encodeURI('PrimaryAddress');
      var url_val = 'http://data.n-somerset.gov.uk/api/'+category_name+'/'+subcategory_name+'/SearchByTextContains?fieldToSearch='+fieldToSearch+'&searchText=&format=json';
    } else if(subcategory_name == 'events') {
      if (article == undefined) {
        var now = new Date();
        var today = now.getDate()+'-'+(now.getMonth()+1)+'-'+now.getFullYear();
        var url_val = 'http://data.n-somerset.gov.uk/api/'+category_name+'/'+subcategory_name+'/SearchSchemaDate?fieldToSearch=EndDate&from='+today+'&format=json';
      } else {
        var fieldToSearch =  encodeURI('Slug');
        var url_val = 'http://data.n-somerset.gov.uk/api/'+category_name+'/'+subcategory_name+'/SearchByTextContains?fieldToSearch='+fieldToSearch+'&searchText='+fieldValue+'&format=json';
      }
    } else if(subcategory_name == 'arts-and-culture') {
      //console.log('Have request for arts and culture');
      if (article == undefined) {
        var fieldToSearch  = encodeURI('CategoryArtsCulture');
        fieldValue = 1;
        subcategory_name = 'sites-and-attractions';
        var url_val = 'http://data.n-somerset.gov.uk/api/'+category_name+'/'+subcategory_name+'/SearchByTextContains?fieldToSearch='+fieldToSearch+'&searchText='+fieldValue+'&format=json';
      } else {
        var fieldToSearch =  encodeURI('Slug');
        subcategory_name = 'sites-and-attractions';
        var url_val = 'http://data.n-somerset.gov.uk/api/'+category_name+'/'+subcategory_name+'/SearchByTextContains?fieldToSearch='+fieldToSearch+'&searchText='+fieldValue+'&format=json';
      }
    } else if(subcategory_name == 'food-and-drink') {
      //console.log('Have request for food and drink');
      if (article == undefined) {
        var fieldToSearch  = encodeURI('Type1');
        fieldValue  = encodeURI('Food & Drink');
        subcategory_name = 'sites-and-attractions';
        var url_val = 'http://data.n-somerset.gov.uk/api/'+category_name+'/'+subcategory_name+'/SearchByTextContains?fieldToSearch='+fieldToSearch+'&searchText='+fieldValue+'&format=json';
      } else {
        var fieldToSearch =  encodeURI('Slug');
        subcategory_name = 'sites-and-attractions';
        var url_val = 'http://data.n-somerset.gov.uk/api/'+category_name+'/'+subcategory_name+'/SearchByTextContains?fieldToSearch='+fieldToSearch+'&searchText='+fieldValue+'&format=json';
      }
    } else if(subcategory_name == 'images') {
      var fieldToSearch =  encodeURI('ImageName');
      var url_val = 'http://data.n-somerset.gov.uk/api/'+category_name+'/'+subcategory_name+'/SearchByTextContains?fieldToSearch='+fieldToSearch+'&searchText='+fieldValue+'&format=json';
    } else if(subcategory_name == 'leisure-centres') {
      var fieldToSearch =  encodeURI('Site');
      var url_val = 'http://data.n-somerset.gov.uk/api/'+category_name+'/'+subcategory_name+'/SearchByTextContains?fieldToSearch='+fieldToSearch+'&searchText='+fieldValue+'&format=json';
    } else if(subcategory_name == 'libraries') {
      var fieldToSearch =  encodeURI('LibraryName');
      var url_val = 'http://data.n-somerset.gov.uk/api/'+category_name+'/'+subcategory_name+'/SearchByTextContains?fieldToSearch='+fieldToSearch+'&searchText='+fieldValue+'&format=json';
    } else if(subcategory_name == 'local-facts') {
      var fieldToSearch =  encodeURI('Slug');
      var url_val = 'http://data.n-somerset.gov.uk/api/'+category_name+'/'+subcategory_name+'/SearchByTextContains?fieldToSearch='+fieldToSearch+'&searchText='+fieldValue+'&format=json';
    } else if(subcategory_name == 'mobile-library') {
      var fieldToSearch =  encodeURI('LibraryName');
      var url_val = 'http://data.n-somerset.gov.uk/api/'+category_name+'/'+subcategory_name+'/SearchByTextContains?fieldToSearch='+fieldToSearch+'&searchText='+fieldValue+'&format=json';
    } else if(subcategory_name === 'sites-and-attractions') {
      //var fieldToSearch  = encodeURI('SiteName');
      var fieldToSearch  = encodeURI('Slug');
      var url_val = 'http://data.n-somerset.gov.uk/api/'+category_name+'/'+subcategory_name+'/SearchByTextContains?fieldToSearch='+fieldToSearch+'&searchText='+fieldValue+'&format=json';
    } else if(subcategory_name.toLowerCase() === 'venues') {
	    var fieldToSearch  = encodeURI('CategoryEventsVenue');
		fieldValue = encodeURI('1');
        subcategory_name = 'sites-and-attractions';
	    var url_val = 'http://data.n-somerset.gov.uk/api/'+category_name+'/'+subcategory_name+'/SearchByTextContains?fieldToSearch='+fieldToSearch+'&searchText='+fieldValue+'&format=json';
    } else {
      console.error("Don't know how to query for "+category_name+"."+subcategory_name);
    }

    return url_val;
  }

  this.query = function(category_name, subcategory_name, article) {
    console.info('query: category_name: '+category_name+', subcategory_name: '+subcategory_name+', article: '+article);
    return $.ajax({
        type:'get',
        //async: false,
        url:$od.init_api_url(category_name,subcategory_name,article),
        dataType: "json",
        xhrFields: {withCredentials: false},
        success:function(data) {
          //console.debug('got data: '+data);
          if (article==undefined) {
            for (i in data) data[i].idx = i;
            $od[category_name+'_'+subcategory_name] = data;
            $od.articles = data;
          } else {
            $od.article = data[0];
            $('#article').html($('#article-template').html()).moustache($od.article);
          }
        }
    });
  }

  /**
   * Initialise a Google map with a set of markers representing an open data query.
   *
   * @see Widget4 Interactive Map.
   */
  this.initInteractiveMap = function() {
    console.info('initInteractiveMap');

		/* Ajax result on load of category page */
		jQuery('#loading-image').html('<img src="<?php echo get_template_directory_uri()?>/images/img/ajax-loading.gif" alt="Loading..."');
		$od.query(category_name,subcategory_name).success(function(data) {
			console.log('$od.query success handler');

			$dns.im.init_google_map(subcategory_name,data);

			jQuery('#loading-image').hide();
		});
  }

  /**
   * Initialise search widget.
   *
   * @see Widget5
   */
  this.initSearch = function() {
    /* Apply month filter (in addition to interest area if set) */
    jQuery('#month').on('change', function() {
			$od.month = this.value;
			console.log('Filter on month:'+this.value);
      $od.filterDataSet(category_name,subcategory_name);
		});

    /* Apply interest area filter (in addition to month if set) */
		jQuery('#interst_area').on('change', function() {
			$od.interestArea = this.value;
			console.log('Filter on interest area:'+this.value);
      $od.filterDataSet(category_name,subcategory_name);
		});

    /* Apply Tags filter (in addition to month, interest area if set) */
		jQuery('a[data-tag]').on('click', function(e) {
		  console.log('Filter on tag:'+$(e.target).data('tag'));
      e.preventDefault();
      $od.tag = $(e.target).data('tag');
      $od.filterDataSet(category_name,subcategory_name);
		});

    /* if type icon clicked (currently disabled) */
		jQuery('a[data-type]').on('click', function(e) {
		  console.log('Filter on type:'+$(e.target).data('type'));
		  e.preventDefault();
      $od.type = $(e.target).data('type');
      $od.filterDataSet(category_name,subcategory_name);
		});
    /* if type select ctrl used */
		jQuery('#searchTypes').on('blur', function(e) {
		  console.log('Filter on type: '+$(e.target).val()+', id: '+e.target.id);
      $od.type = $(e.target).val();
      $od.filterDataSet(category_name,subcategory_name);
		});

    /* Hide/Show map button */
		jQuery("#map").css('position','absolute').css('left','-150%');
		jQuery('#map-button').on('click',function() {
			if(jQuery('#map').css('position') == 'absolute') {
				jQuery('#map-button button').html('Hide map<span class="fa fa-map-marker pull-right"></span>');
				jQuery("#map").css('position','relative').css('left','0%');
			} else {
				jQuery('#map-button button').html('View map<span class="fa fa-map-marker pull-right"></span>');
				jQuery("#map").css('position','absolute').css('left','-150%');
			}
		});
    jQuery('#advancedSearchBtnGroup').on('click',function() {
			if(jQuery('#advancedSearch').css('display') == 'none') {
				jQuery('#advancedSearchBtnGroup button').html('Less<span class="fa fa-search pull-right"></span>');
				jQuery("#advancedSearch").css('display','block');
			} else {
				jQuery('#advancedSearchBtnGroup button').html('More<span class="fa fa-search pull-right"></span>');
				jQuery("#advancedSearch").css('display','none');
			}
		});
  }

  /**
   * Find a random local fact for this week in history.
   *
   * @see Widget3 This Week.
   */
  this.queryThisMonthFact = function() {
    console.info('queryThisMonthFact');
    return $.ajax({
        type:'get',
        url:'http://data.n-somerset.gov.uk/api/culture-leisure-and-heritage/local-facts/SearchByTextContains?fieldToSearch=Month&searchText='+(new Date().getMonth()+1)+'&format=json',
        dataType: "json",
        xhrFields: {withCredentials: false},
        success:function(data) {
          //console.debug('got data: '+data);
          $od.thisWeekFacts = data.filter($od.filterFactByWeek);
          $('#this-week').html($('#this-week-template').html()).moustache($od.thisWeekFacts[Math.floor(Math.random() * $od.thisWeekFacts.length)]);
        }
    });
  }

  /**
   * Apply filters to a previously fetched data set
   */
  this.filterDataSet = function(category, subcategory) {
    console.info('filterDataSet: '+category+','+subcategory);
    var data = $od[category+'_'+subcategory];
    console.debug('data contains:'+data.length);
    if($od['month'] != undefined && $od.month != 'Select') data = data.filter($od.filterByMonth);
    if($od['interestArea'] != undefined && $od.interestArea != 'Select') data = data.filter($od.filterByInterestArea);
    if($od['tags'] != undefined) data = data.filter($od.filterByTag);
    if($od['type'] != undefined) data = data.filter($od.filterByType);
    console.log('data returning: '+data.length);
    return data;
  }

  /**
   * Function to pass to Array.filter.
   */
  this.filterAfterStartDate = function(whatsOnEvent) {
    //console.info('filterAfterStartDate: '+whatsOnEvent[$od.StartDate]);
    return whatsOnEvent['StartDate']!=undefined && $od.StartDate.getTime() < $od.toDate(whatsOnEvent['StartDate']).getTime();
  }

  /**
   * Function to pass to Array.filter.
   */
  this.filterFactByWeek = function(fact) {
    var dayOfMonth = new Date().getDate();
    return fact['Day']!=undefined && fact.Day>=dayOfMonth-4 && fact.Day<=dayOfMonth+4 ;
  }

  /**
   * Function to pass to Array.filter.
   */
  this.filterByMonth = function(whatsOnEvent) {
    //console.info('filterByMonth'+whatsOnEvent[$od.StartDate]);
    return whatsOnEvent['StartDate']!=undefined && whatsOnEvent.StartDate.substring(3,5)==$od.month;
  }

  /**
   * Function to pass to Array.filter.
   */
  this.filterByInterestArea = function(obj) {
    //console.info('filterByInterestArea: '+obj[$od.interestArea]);
    return obj[$od.interestArea]==1;
  }

  /**
   * Function to pass to Array.filter.
   */
  this.filterByTag = function(obj) {
    console.info('filterByTag'+obj[$od.tag]);
    return obj.Tags.indexOf($od.tag)!=-1;
  }

  /**
   * Function to pass to Array.filter.
   */
  this.filterByType = function(obj) {
    console.info('filterByType'+obj[$od.type]);
    return obj.Type1==$od.type || obj.Type2==$od.type;
  }

  /**
   * Render existing data into .bxslider1 container using template in #bxslider-template.
   *
   * @param data The data set to display, any filtering needed must already have been done.
   */
  this.renderThumbnailSlider = function(data) {
		  console.info('renderThumbnailSlider');
      $('.bxslider1').empty();

		  $.each(data, function(i,d) {
		    //console.log('render '+i+', '+JSON.stringify(d));
		    var html = $('#bxslider-template').html();
		    if (d['Date']!=undefined) html = html.replace('{{date}}',d['Date']);
		    console.log(d['EventName']);
		    if (d['EventName']!=undefined) html = html.replace(/{{name}}/g,d['EventName']);
		    if (d['EventName']!=undefined) html = html.replace(/{{slug}}/g,convertToSlug(d['EventName']));
		    if (d['FactName']!=undefined) html = html.replace(/{{name}}/g,d['FactName']);
		    if (d['FactName']!=undefined) html = html.replace(/{{slug}}/g,convertToSlug(d['FactName']));
		    if (d['Image']!=undefined) html = html.replace('{{image}}',d['Image']);
		    if (d['Month']!=undefined) html = html.replace('{{month}}',d['Month']);
		    if (d['SiteName']!=undefined) html = html.replace(/{{name}}/g,d['SiteName']);
		    if (d['SiteName']!=undefined) html = html.replace(/{{slug}}/g,convertToSlug(d['SiteName']));
		    if (d['StartDate']!=undefined) {
		      var s = d['StartDate'];
		      var idx = s.indexOf('/');
		      html = html.replace('{{date}}',s.substring(0,idx));
		      var month = s.substring(idx+1,s.indexOf('/',idx+1));
          switch(month) {
          case '01': month = 'January'; break;
          case '02': month = 'February'; break;
          case '03': month = 'March'; break;
          case '04': month = 'April'; break;
          case '05': month = 'May'; break;
          case '06': month = 'June'; break;
          case '07': month = 'July'; break;
          case '08': month = 'August'; break;
          case '09': month = 'September'; break;
          case '10': month = 'October'; break;
          case '11': month = 'November'; break;
          case '12': month = 'December'; break;
          }
		      html = html.replace('{{month}}',month);
		    }
		    if (d['Type']!=undefined) html = html.replace('{{type}}',d['Type']);
		    if (d['Type1']!=undefined) html = html.replace('{{type}}',d['Type1']);

		    // now remove any moustaches not used
		    html = html.replace('{{date}}','');
		    html = html.replace('{{image}}','');
		    html = html.replace('{{month}}','');
		    //html = html.replace('{{name}}','');
		    html = html.replace('{{time}}','');
		    html = html.replace('{{type}}','');

        // finally set html into slider
		    $('.bxslider1').append(html);
		  });

      if ($od['slider']) $od.slider.reloadSlider();
  }

  this.toDate = function(strDate) {
    return new Date(strDate.substring(6), parseInt(strDate.substring(3,5))-1, strDate.substring(0,2));
  }
}
