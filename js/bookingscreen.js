var model = new Object();
model.objLocation = new Object();
model.lstServices = new Object();
model.generalSLots = new Object();
model.serviceSlots = new Object();
model.selectedDate = null;
model.conf = new Object();

function loadMap(locationDetails) {
	var latitude, longitude;
	if(locationDetails == null)
		return null;
	locationDetails = model.objLocation[locationDetails.locationId];
	latitude = locationDetails.latitude;
	longitude = locationDetails.longitude;
	if(latitude == null || longitude == null)
	{
		$('#additionalInfo').addClass("hide")
		return null;
	}
	$('#additionalInfo').removeClass("hide")
	var myLatlng = new google.maps.LatLng(latitude, longitude);
	var myOptions = {
	  zoom: 16,
	  center: myLatlng,
	  mapTypeId: google.maps.MapTypeId.ROADMAP
	}
	var map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
	
	var marker = new google.maps.Marker({
		position: myLatlng, 
		map: map
	});   
}

function loadAdditionalInfo(additionalInfo) {
	if(additionalInfo == null)
		return null;
	
	$('#additionalInfo').removeClass("hide")
	$('#map_canvas').empty().html(additionalInfo.value);
}

function setService(serviceId, serviceName, duration)
{
	model.serviceId = serviceId;
	model.serviceName = serviceName;
	model.serviceDuration = duration;
}

function getData()
{
    var request = new INTF_Request('', '', null, null);
	var valueMap = new Array();
	if(model.contactId)
	{
		valueMap.push(new BSLMap('CONTACT', model.contactId, null, null, null));
	}
	else if(model.customerId)
	{
		valueMap.push(new BSLMap('CUSTOMER', model.customerId, null, null, null));
	}
	if(model.serviceId && model.serviceId != '')
	{
		valueMap.push(new BSLMap('SERVICE', model.serviceId, null, null, null));
	}
	if(model.serviceRequestId && model.serviceRequestId != '')
	{
		valueMap.push(new BSLMap('SELECTEDSERVICEREQUEST', model.serviceRequestId, null, null, null));
	}
	if(model.providerId && model.providerId != '')
	{
		valueMap.push(new BSLMap('PROVIDER', model.providerId, null, null, null));
	}
	if(model.directproviderId && model.directproviderId != '')
	{
		valueMap.push(new BSLMap('DIRECTPROVIDER', model.directproviderId, null, null, null));
	}
	request = new INTF_Request('', '', valueMap, null);
	sr.errorHandler = {handler : function(e, me)
    {
        //alert('Save Action Failed: Status Code ' + me.status + ' :' + me.responseText);
		model.serviceId = null;
        return false;
    }}
    sr.responseHandler = {handler : function(e, me)
    {
		var result = sr.__getResponse(me);
		model.serviceId = null;
    	//Settingup UI Header for Service List
    	if(!result.length)
    	{
    		return null;
    	}
    	for (var j=0; j< result.length; j++)
        {
        	//Get group and services
			if(result[j].valueMap)
            {
            	var lstGroups = result[j].valueMap;
            	if(lstGroups != null)
            	{
					if(!lstGroups.length)
					{
						lstGroups = [lstGroups];
					}
	            	//If list of groups are available
	            	for (var i = 0; i < lstGroups.length; i++)
	            	{
						if(lstGroups[i].key == 'GROUP' || lstGroups[i].key == 'SERVICES')
						{
							if(lstGroups[i].key == 'GROUP' && lstGroups[i].record && lstGroups[i].record != null)
							{
								model.objLocation[lstGroups[i].record.Id] = {locationId: lstGroups[i].record.Id, locationName: lstGroups[i].record.Name, latitude: lstGroups[i].record.BKSL2__Latitude__c, longitude: lstGroups[i].record.BKSL2__Longitude__c};
							}
							
							var lstObjServices = lstGroups[i].records;
							if(lstObjServices != null)
							{
								if(!lstObjServices.length)
								{
									lstObjServices = [lstObjServices];
								}
								if(model.prop.customSorting){
									model.prop.customSorting(lstObjServices);
								}
								//If list of groups are available
								for (var k = 0; k < lstObjServices.length; k++)
								{
									var full_duration = lstObjServices[k].BKSL2__Duration_Time__c + ' ' + lstObjServices[k].BKSL2__Duration_Unit__c;
									var small_duration = full_duration.replace("Hours","Hrs").replace("Minutes","Mins");
									model.lstServices[lstObjServices[k].Id] = {serviceId: lstObjServices[k].Id, serviceName: lstObjServices[k].Name, duration: full_duration, smallDuration: small_duration, description: lstObjServices[k].BKSL2__Description__c, location: lstObjServices[k].BKSL2__Service_Category__c, googleCalId: lstObjServices[k].BKSL2__Service_Calendar_Id__c, picture: lstObjServices[k].BKSL2__Picture__c};
								}
							}
						}
						else if(lstGroups[i].key == 'SELECTEDSERVICEREQUEST')
						{
							model.previousAppointmentDate = lstGroups[i].value;
						}
						else if(lstGroups[i].key == 'CONTACT' || lstGroups[i].key == 'CUSTOMER')
						{
							model.contactId == null;
							model.contact = lstGroups[i].records;
							if(model.contact.Id)
							{
								model.contactId = model.contact.Id;
								if(lstGroups[i].key == 'CONTACT')
									$('#userReference1').empty().html(model.contact.FirstName + ' ' + model.contact.LastName);
								else
									$('#userReference1').empty().html(model.contact.BKSL2__FirstName__c + ' ' + model.contact.BKSL2__LastName__c);
								$('#existingContact').show();
							}
						}
						else if(lstGroups[i].key == 'SERVICE')
						{
							if(lstGroups[i].records != null)
							{
								setService(lstGroups[i].records.Id, lstGroups[i].records.Name, lstGroups[i].records.Name, lstGroups[i].records.BKSL2__Duration_Time__c + ' ' + lstGroups[i].records.BKSL2__Duration_Unit__c)
							}
						}
						else if(lstGroups[i].key == 'ADDITIONALINFO')
						{
							loadAdditionalInfo({value: lstGroups[i].value});
						}
            		}
            	}
            }
            //Get general slots for service
            if(result[j].valueMap)
            {
            	var lstServiceDays = result[j].valueMap2;
            	if(lstServiceDays != null)
            	{
            		if(!lstServiceDays.length)
            			lstServiceDays = [lstServiceDays];
	            	//If list of groups are available
	            	for (var i = 0; i < lstServiceDays.length; i++)
	            	{
	            		var lstSlots = lstServiceDays[i].childs;
	            		model.generalSLots[lstServiceDays[i].key + '_' + lstServiceDays[i].value] = lstSlots;
            		}
            	}
            	model.conf = JSON.parse(result[j].quickResponse, function (key, value) {
					var type;
					if (value && typeof value === 'object') {
						type = value.type;
						if (typeof type === 'string' && typeof window[type] === 'function') {
							return new (window[type])(value);
						}
					}
					return value;
				});
            }
			if(model.lstServices != null && !jQuery.isEmptyObject(model.lstServices)){
				window.App = BookingApplication.init();
			}
        }
        var strDateFormat = model.conf['SELECTIONDATEFORMAT'];
        if(!strDateFormat)
        	strDateFormat = 'yy-mm-dd';
		var datePickerProperties = {
			dateFormat: strDateFormat,
			minDate: -parseInt(model.conf['NUMBEROFDAYSALLOWEDFROMPAST']), maxDate: "+" + model.conf['NUMBEROFDAYSALLOWEDINFUTURE'] + "D",
			changeMonth: true,
			changeYear: true
		};
		if(model.prop.predefinedDate){
			var dateProp = model.prop.predefinedDate.split("_");
			model.prop.defaultDate = new Date(dateProp[2], dateProp[1]-1, dateProp[0], 0, 0, 0, 0);
			datePickerProperties.defaultDate = model.prop.defaultDate;
		}
        $("#selectedDate").datepicker(datePickerProperties);
		if(model.prop.brandingEnabled){
			var brandImage = new Image();
			brandImage.src = model.conf['BRANDHEADERURL'];
			brandImage.className="hidden-xs img-responsive fullheader";
			$('#brandheader').prepend(brandImage);
			//$('#brandheader').attr("src", model.conf['BRANDHEADERURL']);
		}
		if(model.prop.predefinedDate){
			$('.selectDateOption').addClass("hide");
		}
		$('#brandheadermobile').attr("src", model.conf['BRANDHEADERURLMOBILE']);
		if(model.conf['BASICFOOTER'])
			$('#BKSLBasicfooter').empty().html(model.conf['BASICFOOTER']);
		if(model.conf['BRANDPAGEBGURL'])
			$('body').attr('style', 'background-image:URL('+ model.conf['BRANDPAGEBGURL'] +')');
		
		//Validations
		if(model.lstServices == null || jQuery.isEmptyObject(model.lstServices)){
			$('#bookingscreen1').empty().html('<div style="text-align:center;width:100%;padding:40px 10px;"><b>No service available for the provider. If you are the provider please configure your organization.</b></div>');
		}
    }}
    sr.invoke("INTF_GetAllGroupServices_WS", request);
}

var objDay = {1: 'Mon', 2: 'Tue', 3: 'Wed', 4: 'Thu', 5: 'Fri', 6: 'Sat', 7: 'Sun'};

