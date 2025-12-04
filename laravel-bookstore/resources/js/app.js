import "./bootstrap";

import Alpine from "alpinejs";

window.Alpine = Alpine;

Alpine.start();

import "./books/books-filter.js";
import "./books/create-book.js";
import "./books/edit-books.js";
import "./books/delete-book.js";

import "./books-category/create-category.js";
import "./books-category/edit-category.js";
import "./books-category/delete-category.js";

import "./books-borrowings/issue-borrowings.js";
import "./books-borrowings/borrowings-filter.js";
import "./books-borrowings/borrowing-actions.js";
