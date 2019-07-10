/* dCodes Framework: (c) TemplateAccess */

jQuery(document).ready(function ($) {
	$('.dc_pricingtable05 td, .dc_pricingtable05 th').live('mouseenter', function () {
		var the_parent = $('.dc_pricingtable05');
		the_parent.find('*').removeClass('border_blue');
		var index = $(this).index();
		the_parent.find('tr').each(function (i) {
			var item = $(this);
			if (item.hasClass('grey')) {
				item.find('th:eq(' + index + ') , td:eq(' + index + ')').addClass('w_table_l_grey');
			} else {
				item.find('th:eq(' + index + ') , td:eq(' + index + ')').addClass('w_table_d_grey');
			}
		});
	}).live('mouseleave', function () {
		$('.dc_pricingtable05').find('*').removeClass('w_table_d_grey').removeClass('w_table_l_grey');
	});
	$('.dc_pricingtable06 td, .dc_pricingtable06 th').live('mouseenter', function () {
		var the_parent = $('.dc_pricingtable06');
		the_parent.find('*').removeClass('pricing_blue_btn');
		var index = $(this).index();
		the_parent.find('tr').each(function (i) {
			var item = $(this);
			if (item.hasClass('grey')) {
				item.find('th:eq(' + index + ') , td:eq(' + index + ')').addClass('d_table_l_grey');
			} else {
				item.find('th:eq(' + index + ') , td:eq(' + index + ')').addClass('d_table_d_grey');
			}
		});
	}).live('mouseleave', function () {
		$('.dc_pricingtable06').find('*').removeClass('d_table_l_grey').removeClass('d_table_d_grey');
	});
});
