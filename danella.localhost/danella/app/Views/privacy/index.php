<?= $this->extend('layouts/default'); ?>

<?= $this->section('corousel'); ?>

<!-- corousel-section -->
<?php $dataCarousel = [
	'dataCarouselImage' => '/assets/images/privacy-policy-featured-area.jpg',
	'dataCarouselTitle' => 'Privacy',
	'dataCarouselSubTitle' => 'We are transparent about our data practices and <br> strive to maintain the highest standards of privacy protection.',
	'dataCarouselBreadCrumb' => ['/' => 'Home'],
	'dataCarouselBreadCrumbActive' => 'Privacy',
]; ?>
<?= view_cell('\App\Cells\MainCell::carousel', $dataCarousel); ?>

<?= $this->endSection(); ?>


<?= $this->section('content'); ?>

<!-- privacy-section -->
<?php // https://www.privacypolicytemplate.net/live.php?token=1P8ZMhPlHZKwXqyPteiyOSgIXF68777x  ?>
<?php // https://www.privacypolicytemplate.net/live.php?token=1P8ZMhPlHZKwXqyPteiyOSgIXF68777x  ?>
<?php // https://www.privacypolicytemplate.net/live.php?token=1P8ZMhPlHZKwXqyPteiyOSgIXF68777x  ?>
<section class="mb-5 anima-here">
	<div class="container">
		<div class="row row-cols-1">
			<div class="card">
				<div class="card-body">
					<div>
						<div class="card-title fw-bold">Privacy Policy</div>

						<p><?= $information['name']; ?> operates the <?= $information['website']; ?> website, which
							provides the
							SERVICE.</p>

						<p>This page is used to inform website visitors regarding our policies with the
							collection, use,
							and
							disclosure of Personal Information if anyone decided to use our Service, the
							<?= $information['name']; ?>
							website.
						</p>

						<p>If you choose to use our Service, then you agree to the collection and use of
							information in
							relation with this policy. The Personal Information that we collect are used for providing
							and
							improving the Service. We will not use or share your information with anyone except as
							described
							in this Privacy Policy.</p>

						<p>The terms used in this Privacy Policy have the same meanings as in our Terms and
							Conditions,
							which is accessible at <?= $information['website']; ?>, unless otherwise defined in this Privacy
							Policy.
						</p>

					</div>


					<div>
						<div class="card-title fw-bold">Information Collection and Use</div>

						<p>For a better experience while using our Service, we may require you to provide us
							with
							certain
							personally identifiable information, including but not limited to your name, phone number,
							and
							postal address. The information that we collect will be used to contact or identify you.</p>
					</div>


					<div>
						<div class="card-title fw-bold">Service Providers</div>

						<p>We may employ third-party companies and individuals due to the following reasons:
						</p>

						<ul>
							<li>
								<span class="dot">&#9679;</span>
								<div>To facilitate our Service;</div>
							</li>
							<li>
								<span class="dot">&#9679;</span>
								<div>To provide the Service on our behalf;</div>
							</li>
							<li>
								<span class="dot">&#9679;</span>
								<div>To perform Service-related services; or</div>
							</li>
							<li>
								<span class="dot">&#9679;</span>
								<div>To assist us in analyzing how our Service is used.</div>
							</li>
						</ul>

						<p>We want to inform our Service users that these third parties have access to your
							Personal
							Information. The reason is to perform the tasks assigned to them on our behalf. However,
							they
							are obligated not to disclose or use the information for any other purpose.</p>
					</div>


					<div>
						<div class="card-title fw-bold">Security</div>

						<p>We value your trust in providing us your Personal Information, thus we are
							striving to use
							commercially acceptable means of protecting it. But remember that no method of transmission
							over
							the internet, or method of electronic storage is 100% secure and reliable, and we cannot
							guarantee its absolute security.</p>
					</div>



					<div>
						<div class="card-title fw-bold">Links to Other Sites</div>

						<p>Our Service may contain links to other sites. If you click on a third-party link,
							you will be
							directed to that site. Note that these external sites are not operated by us. Therefore, we
							strongly advise you to review the Privacy Policy of these websites. We have no control over,
							and
							assume no responsibility for the content, privacy policies, or practices of any third-party
							sites or services.</p>
					</div>

					<div>
						<div class="card-title fw-bold">Children's Privacy</div>

						<p>Our Services do not address anyone under the age of 13. We do not knowingly
							collect personal
							identifiable information from children under 13. In the case we discover that a child under
							13
							has provided us with personal information, we immediately delete this from our servers. If
							you
							are a parent or guardian and you are aware that your child has provided us with personal
							information, please contact us so that we will be able to do necessary actions.</p>
					</div>



					<div>
						<div class="card-title fw-bold">Changes to This Privacy Policy</div>

						<p>We may update our Privacy Policy from time to time. Thus, we advise you to review
							this page
							periodically for any changes. We will notify you of any changes by posting the new Privacy
							Policy on this page. These changes are effective immediately, after they are posted on this
							page.</p>
					</div>


					<div class="mb-4">
						<div class="card-title fw-bold">Contact Us</div>

						<p>If you have any questions about these Privacy Policy, You can contact us:
						</p>
						<ul>
							<li>
								<span class="dot">&#9679;</span>
								<div>By email: <?= $information['email'][0]; ?></div>
							</li>
							<li>
								<span class="dot">&#9679;</span>
								<div>By phone number: <?= $information['call'][0]; ?></div>
							</li>
						</ul>
					</div>

				</div>
			</div>
		</div>
	</div>
</section>



<?= $this->endSection(); ?>