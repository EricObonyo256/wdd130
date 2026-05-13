#!/usr/bin/env node
const fs = require('fs');
const path = require('path');

const folder = path.join(__dirname, '..', 'ggr');
const files = fs.readdirSync(folder).filter(f => f.endsWith('.html'));

function checkFile(file) {
  const full = path.join(folder, file);
  const src = fs.readFileSync(full, 'utf8');
  const issues = [];

  if (!/<!DOCTYPE html>/i.test(src)) issues.push('Missing DOCTYPE');
  if (!/<html [^>]*lang=/.test(src)) issues.push('Missing lang attribute on <html>');
  if (!/<meta[^>]*name=["']description["'][^>]*>/i.test(src)) issues.push('Missing meta description');
  if (!/class=["']skip-link["']/.test(src) && !/href=["']#main["']/.test(src)) issues.push('Missing skip link');
  if (!/role=["']main["']/.test(src) && !/id=["']main["']/.test(src)) issues.push('Missing main role or #main');

  // images missing alt
  const imgTags = src.match(/<img [^>]*>/g) || [];
  imgTags.forEach((img) => {
    if (!/alt=/.test(img)) issues.push('Image tag without alt attribute: ' + img.slice(0, 80));
  });

  // forms: label for inputs
  const forms = src.match(/<form[\s\S]*?<\/form>/gi) || [];
  forms.forEach(form => {
    const inputs = form.match(/<(input|textarea)[^>]*>/gi) || [];
    inputs.forEach(inp => {
      const hasId = /id=/.test(inp);
      if (hasId) {
        const id = inp.match(/id=["']([^"']+)["']/i)[1];
        if (!new RegExp(`<label[^>]*for=["']${id}["']`, 'i').test(form)) {
          issues.push(`Form input missing matching <label for="${id}">`);
        }
      } else {
        issues.push('Form input missing id (so label cannot reference it): ' + inp.slice(0, 80));
      }
    });
  });

  return issues;
}

let total = 0;
files.forEach(file => {
  const issues = checkFile(file);
  total += issues.length;
  console.log(`\nReport for ${file}:`);
  if (issues.length === 0) console.log('  No obvious issues found');
  else issues.forEach(i => console.log('  - ' + i));
});

console.log(`\nSummary: scanned ${files.length} files, ${total} issues found.`);
