# FPDF EasyTable

It is a PHP class that provides an easy way to make tables for PDF documents that are generate with the 
[FPDF library](http://www.fpdf.org).

Making tables for PDF documents with this class is as easy and flexible as
making HTML tables. And using CSS-style strings we can customize the look of 
the tables in the same fashion HTML tables are styling with CSS. 

No messy code with confusing arrays of attributes and texts.

No complicated configuration files.

Building and styling a table with easyTable is simple, clean and fast.

```
 $table=new easyTable($pdf, 3, 'width:100;');
 
 $table->easyCell('Text 1', 'rowspan:2; valign:T'); 
 $table->easyCell('Text 2', 'bgcolor:#b3ccff; rowspan:2');
 $table->easyCell('Text 3');
 $table->printRow();
 
 $table->rowStyle('min-height:20');
 $table->easyCell('Text 4', 'bgcolor:#3377ff; rowspan:2');
 $table->printRow();

 $table->easyCell('Text 5', 'bgcolor:#99bbff;colspan:2');
 $table->printRow();
 
 $table->endTable();
```
 
# Features

- Table and columns width can be defined in mm or percentage

- Every table cell is a fully customizable 
  (font family, font size, font color, background color, position of the text, 
  vertical padding, horizontal padding...)

- Cells can span to multiple columns and rows

- Tables split automatically on page-break

- Set of header row, so the header can be added automatically on every new page

- Attribute values can be defined globally, at the table level (affect all the cells in the table), 
  at the row level (will affect just the cells in that row), or locally at the cell level

- By default, rows does not splitdoes not break rows

- Images can be added to table cells

- Text can be added on top or below an image in a cell

# Examples

- [Evolution of a table](https://github.com/fpdf-easytable/fpdf-easytable/blob/master/example-1.pdf)
  * [Code](https://github.com/fpdf-easytable/fpdf-easytable/blob/master/example1.php)
  
- [Table with header](https://github.com/fpdf-easytable/fpdf-easytable/blob/master/example-2.pdf)
  * [Code](https://github.com/fpdf-easytable/fpdf-easytable/blob/master/example2.php)

- [Simple invoice](https://github.com/fpdf-easytable/fpdf-easytable/blob/master/example-3.pdf)
  * [Code](https://github.com/fpdf-easytable/fpdf-easytable/blob/master/example3.php)

# Requirements

- [FPDF 1.81](http://www.fpdf.org).
- exfpdf.php (included in this project)

# Manual Install

Download the class and put the contents in a directory in your project structure.
Be sure you are using [FPDF 1.81](http://www.fpdf.org).

# Quick Start

- create a fpdf object with exfpdf class (extension of fpdf class)
- create a easyTable object
```
    $table=new easyTable($pdf, 3, 'border:1');
```    
- add some rows
```
    $table->easyCell('Text 1', 'valign:T'); 
    $table->easyCell('Text 2', 'bgcolor:#b3ccff;');
    $table->easyCell('Text 3');
    $table->printRow();

    $table->rowStyle('min-height:20; align:{C}');   // let's adjust the height of this row
    $table->easyCell('Text 4', 'colspan:3');
    $table->printRow();
```
- when it is done, do not forget to terminate the table
```
    $table->endTable(4);
```
  [Result](https://github.com/fpdf-easytable/fpdf-easytable/blob/master/basic_example.pdf)
  * [Code](https://github.com/fpdf-easytable/fpdf-easytable/blob/master/basic_example.php)


# Documentation

**function __construct( FPDF-object $fpdf_obj, Mix $num_cols[, string $style = '' ])**

*Description:*

   Constructs an easyTable object

*Parameters:*

fpdf_obj

    the current FPDF object (constructed with the FPDF library)  
    that is being used to write the current PDF document

num_cols

    this parameter can be a positive integer (the number of columns)
    or a string of the following form
   
    I) a positive integer, the number of columns for the table. The width
      of every column will be equal to the width of the table (given by the width property)
      divided by the number of columns ($num_cols)

    II) a string of the form '{c1, c2, c3,... cN}'. In this case every 
       element in the curly brackets is a positive numeric value that represent 
       the width of a column. Thus, the n-th numeric value is the width 
       of the n-th colum. If the sum of all the width of the columns is bigger than
       the width of the table but less than the width of the document, the table 
       will stretch to the sum of the columns width. However, if the sum of the 
       columns is bigger than the width of the document, the width of every column
       will be reduce proportionally to make the total sum equal to the width of the document. 

   III) a string of the form '%{c1, c2, c3,... cN}'. Similar to the previous case, but
        this time every element represents a percentage of the width of the table.
        In this case it the sum of this percentages is bigger than 100, the execution will
        be terminated.

style

    the global style for the table (see documentation)
    a semicolon-separated string of attribute values that defines the 
    default layout of the table and all the cells and their contents
    (see Documentation section in README.md)

*Examples:*
```
    $table= new easyTable($fpdf, 3);
    $table= new easyTable($fpdf, '{35, 45, 55}', 'width:135;');
    $table= new easyTable($fpdf, '%{35, 45, 55}', 'width:190;');
```   
   
*Return value:*

   An easyTable object    


**function rowStyle( string $style )**

*Description:*

   Set or overwrite the style for all the cells in current.

*Parameters:*

style
   
   a semicolon-separated string of attribute values that defines the 
   layout of all the cells and its content in the current row 
   (see Documentation section in README.md)

*Return values*

   Void
   
*Notes:*

   This function should be called before the first cell of the current row


**function easyCell( string $data [, string $style = '' ])**

*Description:*

    Makes a cell in the table

*Parameters:*

data   
    the content of the respective cell

style (optional)
    a semicolon-separated string of attribute values that defines the 
    layout of the cell and its content (see Documentation section in README.md)

*Return value*

    void
   


**function printRow ( [ bool $setAsHeader = false ] )**

*Description:*

   This function indicates the end of the current row. 

*Parameters:*

setAsHeader (optional)

    Optional. When it is set as true, and it mark the current row as the header
    of the table; it will be printed on the pages that the table split
    Remark: 1. In order to work, the table attribute split-row should set as true. 
            2. Just the first row where this parameter is set as true will be
              used as header any other will printed as a normal row.

*Return values*

   Void

*Note:*

   This function will print the current row as far as the following holds:
```   
      total_rowspan=0
```
   where total_rowspan is set as 
```   
      total_rowspan=max(total_rowspan, max(rowspan of cell in the current row))-1;
```             

**function endTable( [ int $bottomMargin = 2 ])**

*Description:*

   Unset all the data members of the easyTable object

*Parameters:*

bottomMargin (optional)

   Optional. Specify the number of white lines left after 
   the last row of the table. Default 2.
   
   If it is negative, the vertical position will be set before
   the end of the table.   

*Return values*

   Void


**Style String**

In the same fashion as in-line CSS style, Easy Table uses 
strings of semicolon-separated pairs of properties/values to
define the styles to be applied to the different parts of 
a table. A value set on a property at the table level will be inherited 
by all the rows (therefore all the cells) in the table. A value set
on a property at the row level, will be overwrite the value inherited from the table
and, will be passed to all the cells in that row, unless a cell 
defines its own value for that property.

In what follows, we are going to use the following notation:

    C=cell
    R=row
    T=table

**PROPERTY** [C/R/T] means that the property PROPERTY can be set on cells, rows, table. 

Full list of properties:

**width** [T]

The width property sets the width of a table.
This property can be defined in millimetres or in percentage of the width of the document.

Syntax:

    width:mm|%;

Examples:

    width:145;
    width:70%;

Default: the width of the document minus the right and left margin.
   
**border** [C/R/T]

The border property indicates if borders must be drawn around the cell or the cells. 
The value can be either a number:

    0: no border
    1: frame

or a string containing some or all of the following characters (in any order):

    L: left border
    T: top border
    R: right border
    B: bottom border

Default value: 0. 


**border-color** [T]

The border-color property is used to set the colour of the border to be drawn 
around the cells. The value can be: Hex color code or RGB color code.

Syntax:

    border-color: Hex |RGB;

Example:

    border-color:#ABCABC;
    border-color:79,140, 200;

Default value: the current drawn colour set in the document

**split-row** [T]

This property indicate if a row that is at the bottom of the page should be split or not
when it reaches the bottom margin, except for rows that contains cell that span
to different rows, in this case the row splits. By the fault, any row that does not fit in the page
is printed in the next page. Setting the property to false, it will split any row
between the pages. 

Example: 

    split-row:false;


**l-margin** [T]

This property indicate the distance from the left margin from where the table should start.

Syntax:

    l-maring:mm;

Example:

    l-maring:45;

Default value: 0.

**min-height** [R] 

The min-height property set the minimum height for all the cells (with rowspan:1) in that
specific row.

Syntax:

    min-height:mm;

Example:

    min-height:35;


Default value: 0.

**align** [C/R/T] 

This property indicates the horizontal alignment of the element in which it is set.
The values can be: 

    L: to the left
    C: at the centre
    R: to the right
    J: justified (applicable just on cells)

Syntax for tables is:

    align:A;
    align:A{A-1A-2A-3A-4...};

Explanation: the first character indicates the horizontal alignment of the table 
(as far as l-margin is not set), while the optional string is a string of the form: 
{A-1A-2A-3A-4...} (curly brackets included) where A-1, A-2, A-3, A-4, etc. can be L, C, R or J and
the A-n letter indicates the horizontal alignment for the content of all the cells in the
n-th row. If the number of rows is greater than the length of the optional string, 
the overflowed rows will have default alignment to the left (L).

Example: (table with 10 rows)

    align:R{CCCLLJ};

means that the table is aligned to the right of the document, the content of the 
cells in the first three rows will be aligned at the centre, the content of the
cells in the 4-th and 5-th rows will be aligned to the left and the the content of cells in 
the 6-th row will be aligned to the right, while the rest of the cell contents in the remaining 
rows will be aligned to the left.

Syntax for rows is

    align:{A-1A-2A-3A-4...};

where A-1, A-2,... etc are as in the table case and with the same functionality: 
the A-n character indicates the alignment of the cells in the n-th column that are
in the respective row.

Example:

    align:{LRCCRRLJ}

Syntax for cells is

    align:A;

where A can be L, C, R, J.

Default value: L.

**valign** [C/R/T] 

The property valign defines the vertical alignment of the content of the cells.
The values can be:

    T: top
    M: middle
    B: bottom

Example:

    valign:M; 

Default: T.

Remark: *when using valign property on cell with image property set (see below),
if the cell does not have text, the behaviour of valign is as expected, this is,
the image is positioned accordingly to the value of valign. However, if the cell contains
text, the image and the text are valign-ed in the middle of the cell but 
top (T) or middle (M) valign set the text on top of the image, while valign:B set the text 
under the image.*


**bgcolor** [C/R/T]

The bgcolor property defines the background colour of the cells
The value can be: Hex color code or RGB color code.

Syntax:

    bgcolor:Hex | RGB;

Example:

    bgcolor:#ABCABC;
    bgcolor:79,140, 200;

Default: the current fill color set in the document


**font-family** [C/R/T],

It can be either a name defined by the FPDF method AddFont() or 
one of the standard families (case insensitive):

    Courier (fixed-width)
    Helvetica or Arial (synonymous; sans serif)
    Times (serif)
    Symbol (symbolic)
    ZapfDingbats (symbolic)

It is also possible to pass an empty string. In that case, the current family is kept. 

Example:

    font-family:times;

Default: the font-family set in the document.

**font-style** [C/R/T]

Possible values are (case insensitive):

    empty string: regular
    B: bold
    I: italic
    U: underline

or any combination. The default value is regular. Bold and italic styles do not 
apply to Symbol and ZapfDingbats. 

Example:

    font-style:IBU

Default: empty;

**font-size** [C/R/T]

Font size in points.

Example:

    font-size:16;

Default: the current font size of the document.

**font-color** [C/R/T]

This property defines the color of the font for the cells
The value can be: Hex color code or RGB color code.

Syntax:

    font-color:Hex |RGB;

Example:

    font-color:#ABCABC;
    font-color:79,140, 200;

Default value: the current font color set in the document


**paddingX** [C/R/T] 

The paddingX property sets the left and right padding (space) of the cells.

Syntax:

    paddingX:mm;

Example:

    paddingX:4;

Default: 0.5.

**paddingY** [C/R/T] 

The paddingY property sets the top and bottom padding (space) of the cells.

Syntax

    paddingY:mm;

Example:

    paddingY:3;

Default: 1.

**colspan** [C]

The colspan attribute defines the number of columns a cell should span.

Syntax:

    colspan:4;

Default 1

**rowspan** [C]
The rowspan attribute defines the number of rows a cell should span.

Syntax:

    rowspan:2;

Default 1

**img** [C]
The img attribute defines the image its dimensions to be set in the cell.

Syntax:

    img:image.png,w80,h50;
    img:image.png,h50;
    img:image.png;

If no dimensions are specified, the image dimensions are calculate proportionally 
to fit the width of the cell.
If one out of the two dimensions (width or height) is specified but not the other
the one that is not specified is calculated proportionally.
Default value: empty.

# Donations


# License

This program is free software; you can redistribute it and/or modify
it under the terms of the [GNU General Public License](http://www.gnu.org/licenses/gpl.txt) 
as published by the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.
 
This program is distributed in the hope that it will be useful, but
WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
General Public License for more details.



